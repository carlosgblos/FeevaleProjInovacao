<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\Currency;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index(Request $request)
    {
        // Fetch wallets that are accessible by the authenticated user
        $wallets = Wallet::accessibleByUser()->paginate(10);

        return view('wallet.index', compact('wallets'));

    }

    public function create()
    {
        $currencies = Currency::all();
        return view('wallet.create', compact('currencies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'nullable|string',
            'id_currency' => 'nullable|exists:currency,id',
        ]);

        Wallet::create($request->all());
        return redirect()->route('wallet.index')->with('success', 'Carteira criada com sucesso.');
    }

    public function edit(Wallet $wallet)
    {
        if ($wallet->id_owner != auth()->id()) {
            abort(403);
        }

        $currencies = Currency::all();
        return view('wallet.edit', compact('wallet', 'currencies'));
    }

    public function update(Request $request, Wallet $wallet)
    {
        if ($wallet->id_owner != auth()->id()) {
            abort(403);
        }

        $request->validate([
            'description' => 'nullable|string',
            'id_currency' => 'nullable|exists:currency,id',
        ]);

        $wallet->update($request->all());
        return redirect()->route('wallet.index')->with('success', 'Carteira atualizada com sucesso.');
    }

    public function destroy(Wallet $wallet)
    {
        if ($wallet->id_owner != auth()->id()) {
            abort(403);
        }

        $wallet->delete();
        return redirect()->route('wallet.index')->with('success', 'Carteira excluída com sucesso.');
    }
}
