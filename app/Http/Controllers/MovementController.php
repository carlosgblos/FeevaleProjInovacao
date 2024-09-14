<?php

// app/Http/Controllers/MovementController.php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Models\Wallet;
use App\Models\MovementType;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MovementController extends Controller
{

    public function index(Request $request)
    {
        $query = Movement::accessibleByUser();

        // Filter by movement type (dropdown selection)
        if ($request->has('id_movement_type') && !empty($request->id_movement_type)) {
            $query->where('id_movement_type', $request->id_movement_type);
        }

        // Filter by date range (if provided)
        if ($request->has('transaction_at_start') && !empty($request->transaction_at_start)) {
            $query->where('transaction_at', '>=', $request->transaction_at_start);
        }
        if ($request->has('transaction_at_end') && !empty($request->transaction_at_end)) {
            $query->where('transaction_at', '<=', $request->transaction_at_end);
        }

        // Filter by wallet (if provided)
        if ($request->has('wallet_id') && !empty($request->wallet_id)) {
            $query->where('id_wallet', $request->wallet_id);
        }

        // Filter by transaction type (Crédito or Débito)
        if ($request->has('transaction_type') && !empty($request->transaction_type)) {
            $query->where('transaction_type', $request->transaction_type);
        }

        // Filter by movement description
        if ($request->has('description') && !empty($request->description)) {
            $query->where('description', 'ilike', '%' . $request->description . '%');
        }


        $movements = $query->paginate(10);

        // Fetch movement types for the dropdown
        $movementTypes = MovementType::all();

        // Convert transaction_at to Carbon instance
        foreach ($movements as $movement) {
            $movement->transaction_at = Carbon::parse($movement->transaction_at);
        }

        // Fetch wallets for the dropdown filter
        $wallets = Wallet::accessibleByUser()->get();

        return view('movement.index', compact('movements', 'wallets', 'movementTypes'));
    }

    public function create()
    {
        // Fetch wallets the user owns or is shared with
        $wallets = Wallet::accessibleByUser()->get();

        return view('movement.create', compact('wallets'));
    }

    public function store(Request $request)
    {
        // Validate input first
        $request->validate([
            'description' => 'nullable|string',
            'vlr' => 'required|string',
            'transaction_at' => 'required|date',
            'id_movement_type' => 'required|exists:movement_type,id',
            'transaction_type' => 'required|in:C,D',
            'id_wallet' => 'required|exists:wallet,id',
        ]);

        try {
            // Convert 'vlr' from PT-BR format to English format
            $vlr = str_replace('.', '', $request->vlr);
            $vlr = str_replace(',', '.', $vlr);
            $request->merge(['vlr' => $vlr]);

            // Create a new movement
            Movement::create($request->all());

            return redirect()->route('movement.index')->with('success', 'Movimento criado com sucesso.');
        } catch (Exception $e) {
            // Log the error for debugging
            Log::error('Error saving movement: ' . $e->getMessage());

            // Redirect back with an error message
            return redirect()->back()->withErrors(['error' => 'Ocorreu um erro ao salvar o movimento. Por favor, tente novamente.' . $e->getMessage()]);
        }
    }

    public function edit(Movement $movement)
    {
        // Ensure the user has access to this movement (via wallet ownership or shared access)
        if (!$movement->wallet->accessibleByUser()) {
            abort(403);
        }
        $wallet = $movement->wallet;


        $wallets = Wallet::accessibleByUser()->get();
        $movementTypes = MovementType::where('id_owner', $wallet->id_owner)->get();


        //return view('movement.edit', compact('movement', 'wallets'));
        return view('movement.edit', compact('movement', 'wallets', 'movementTypes'));

    }

    public function update(Request $request, Movement $movement)
    {
        // Validate input
        $request->validate([
            'description' => 'nullable|string',
            'vlr' => 'required|string',
            'transaction_at' => 'required|date',
            'id_movement_type' => 'required|exists:movement_type,id',
            'transaction_type' => 'required|in:C,D',
            'id_wallet' => 'required|exists:wallet,id',
        ]);

        // Convert 'vlr' from PT-BR format to English format (dot for decimal, no thousand separators)
        $vlr = str_replace('.', '', $request->vlr); // Remove thousand separators
        $vlr = str_replace(',', '.', $vlr); // Replace comma with dot for decimal separator

        // Update the request with the converted value
        $request->merge(['vlr' => $vlr]);

        // Update the movement
        $movement->update($request->all());

        return redirect()->route('movement.index')->with('success', 'Movimento atualizado com sucesso.');
    }

    public function destroy(Movement $movement)
    {
        // Ensure the user has access to this movement
        if (!$movement->wallet->accessibleByUser()) {
            abort(403);
        }

        // Delete the movement
        $movement->delete();

        return redirect()->route('movement.index')->with('success', 'Movimento excluído com sucesso.');
    }

    // Fetch movement types for a specific wallet
    public function getMovementTypes(Request $request, $walletId)
    {
        // Find wallet
        $wallet = Wallet::accessibleByUser()->findOrFail($walletId);

        // Fetch movement types owned by the wallet owner
        $movementTypes = MovementType::where('id_owner', $wallet->id_owner)->get();

        return response()->json($movementTypes);
    }
}
