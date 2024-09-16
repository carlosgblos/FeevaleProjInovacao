<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Models\Movement;
use App\Models\MovementType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $forceReload = 'N';
        $startDate = '';
        $endDate = '';
        // Fetch filters
        $wallets = Wallet::accessibleByUser()->get();
        $movementTypes = MovementType::query()->accessibleByUser()->get();
        // Handle filtering based on request inputs (wallet, movement type, description, date range)
        $query = Movement::accessibleByUser();
        $queryMinDate = Movement::accessibleByUser();

        if ($request->filled('wallet_id')) {
            $query->where('id_wallet', $request->wallet_id);
        }

        if ($request->filled('movement_type_id')) {
            $query->where('id_movement_type', $request->movement_type_id);
        }

        if ($request->filled('description')) {
            $query->where('description', 'ilike', '%' . $request->description . '%');
        }

        if ($request->filled('date_range')) {
            $dateRange = explode(' - ', $request->date_range);
            $startDate = Carbon::createFromFormat('d/m/Y', trim($dateRange[0]));
            $endDate = Carbon::createFromFormat('d/m/Y', trim($dateRange[1]));

            $query->whereBetween('transaction_at', [$startDate, $endDate]);

            //$queryMinDate->select(DB::raw('SUM(case when transaction_type = \'C\' then vlr else vlr * -1 end) as balance'))
            //->where('transaction_at', '<', $startDate);
            //$lat = $queryMinDate->get();

            //$oldTotal = $lat[0]['balance'];
        } else {
            $forceReload = 'Y';
        }

        // Retrieve data for charts
        $movements = $query->get();

        // Calculate wallet balances
        $walletBalances = $this->calculateWalletBalances($movements);

        // Prepare data for bar charts
        $creditData = $this->getMovementTypeData($movements, 'C');
        $debitData = $this->getMovementTypeData($movements, 'D');

        // Extract the labels and values for the bar charts
        $creditLabels = $creditData['labels'];
        $creditValues = $creditData['values'];
        $debitLabels = $debitData['labels'];
        $debitValues = $debitData['values'];

        // Calculate completed and future balances
        $completedBalance = $this->calculateCompletedBalance($movements);
        $futureBalance = $this->calculateFutureBalance($movements);

        // Calculate total money by day for the line chart
        $dailyTotals = $this->getDailyTotals($movements);

        return view('dashboard', compact('wallets', 'movementTypes', 'movements', 'walletBalances', 'creditData', 'debitData', 'completedBalance', 'futureBalance', 'creditLabels', 'creditValues',
            'debitLabels', 'debitValues',
            'dailyTotals', 'forceReload', 'startDate', 'endDate' ));
    }

    public function getDailyTotals($movements)
    {
        // If no movements, return empty data
        if ($movements->isEmpty()) {
            return [
                'dates' => [],
                'totals' => []
            ];
        }

        // Get the earliest and latest transaction dates
        $startDate = $movements->min('transaction_at')->startOfDay();
        $endDate = $movements->max('transaction_at')->endOfDay();

        // Initialize an array to store the cumulative totals by day
        $dailyTotals = [];

        // Initialize total
        $cumulativeTotal = 0;

        // Iterate over each day in the range
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            // Filter movements for this specific day
            $dayMovements = $movements->filter(function($movement) use ($date) {
                return $movement->transaction_at->isSameDay($date);
            });

            // Calculate the total for this day
            foreach ($dayMovements as $movement) {
                if ($movement->transaction_type == 'C') {
                    $cumulativeTotal += $movement->vlr;  // Add credits
                } else {
                    $cumulativeTotal -= $movement->vlr;  // Subtract debits
                }
            }

            // Store the cumulative total for this day
            $dailyTotals[$date->format('Y-m-d')] = $cumulativeTotal;
        }

        // Return the totals, with the dates as keys
        return [
            'dates' => array_keys($dailyTotals),
            'totals' => array_values($dailyTotals),
        ];
    }



    public function calculateWalletBalances($movements)
    {
        // Group movements by wallet
        $walletBalances = [];

        foreach ($movements as $movement) {
            $walletId = $movement->id_wallet;

            if (!isset($walletBalances[$walletId])) {
                $walletBalances[$walletId] = [
                    'description' => $movement->wallet->description,
                    'balance' => 0
                ];
            }

            // Add or subtract value based on transaction type
            if ($movement->transaction_type == 'C') {
                $walletBalances[$walletId]['balance'] += $movement->vlr;  // Credit
            } else {
                $walletBalances[$walletId]['balance'] -= $movement->vlr;  // Debit
            }
        }

        return $walletBalances;
    }

    /**
     * Prepare data for bar charts by movement type.
     *
     * @param \Illuminate\Support\Collection $movements
     * @param string $transactionType ('C' for credit, 'D' for debit)
     * @return array
     */
    public function getMovementTypeData($movements, $transactionType)
    {
        $movementTypeData = [];

        // Group movements by movement type
        foreach ($movements as $movement) {
            if ($movement->transaction_type == $transactionType) {
                $movementTypeId = $movement->id_movement_type;

                if (!isset($movementTypeData[$movementTypeId])) {
                    $movementTypeData[$movementTypeId] = [
                        'description' => $movement->movementType->description,
                        'total' => 0
                    ];
                }

                $movementTypeData[$movementTypeId]['total'] += $movement->vlr;
            }
        }

        // Extract labels and values for the chart
        $labels = array_column($movementTypeData, 'description');
        $values = array_column($movementTypeData, 'total');

        return [
            'labels' => $labels,
            'values' => $values,
        ];
    }

    /**
     * Calculate completed balance (where transaction date <= today).
     *
     * @param \Illuminate\Support\Collection $movements
     * @return float
     */
    public function calculateCompletedBalance($movements)
    {
        $completedBalance = 0;
        $today = now();

        foreach ($movements as $movement) {
            if ($movement->transaction_at <= $today) {
                if ($movement->transaction_type == 'C') {
                    $completedBalance += $movement->vlr;  // Credit
                } else {
                    $completedBalance -= $movement->vlr;  // Debit
                }
            }
        }

        return $completedBalance;
    }

    /**
     * Calculate future balance (where transaction date > today).
     *
     * @param \Illuminate\Support\Collection $movements
     * @return float
     */
    public function calculateFutureBalance($movements)
    {
        $futureBalance = 0;
        $today = now();

        foreach ($movements as $movement) {
            if ($movement->transaction_at > $today) {
                if ($movement->transaction_type == 'C') {
                    $futureBalance += $movement->vlr;  // Credit
                } else {
                    $futureBalance -= $movement->vlr;  // Debit
                }
            }
        }

        return $futureBalance;
    }
}
