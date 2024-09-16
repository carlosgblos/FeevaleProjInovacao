<?php

// app/Http/Controllers/WalletSharedToController.php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\WalletSharedTo;
use Illuminate\Http\Request;

class WalletSharedToController extends Controller
{
    public function index(Request $request)
    {
        // Fetch walletshared where the wallet belongs to the authenticated user
        $walletSharedTos = WalletSharedTo::withUserWallets()->paginate(10);

        return view('walletshared.index', compact('walletSharedTos'));
    }

    public function create()
    {
        // Get wallets belonging to the authenticated user
        $wallets = Wallet::where('id_owner', auth()->id())->get();

        return view('walletshared.create', compact('wallets'));
    }

    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'wallet_id' => 'required|exists:wallet,id',
            'email' => 'required|email',
            'reason' => 'nullable|string',
        ]);

        // Create a new walletshared entry
        WalletSharedTo::create($request->all());

        return redirect()->route('walletshared.index')->with('success', 'Carteira Compartilhada criada com sucesso.');
    }

    public function edit($id)
    {

        $walletSharedTo = WalletSharedTo::with('wallet')->findOrFail($id);

        // Ensure that the wallet belongs to the authenticated user
        if ($walletSharedTo->wallet && $walletSharedTo->wallet->id_owner != auth()->id()) {
            abort(403);
        }

        // Get wallets belonging to the authenticated user
        $wallets = Wallet::where('id_owner', auth()->id())->get();

        return view('walletshared.edit', compact('walletSharedTo', 'wallets'));
    }

    public function update(Request $request, WalletSharedTo $walletSharedTo)
    {
        // Ensure that the wallet belongs to the authenticated user
        if ($walletSharedTo->wallet->id_owner != auth()->id()) {
            abort(403);
        }

        // Validate the input
        $request->validate([
            'wallet_id' => 'required|exists:wallet,id',
            'email' => 'required|email',
            'reason' => 'nullable|string',
        ]);

        // Update the walletshared entry
        $walletSharedTo->update($request->all());

        return redirect()->route('walletshared.index')->with('success', 'Carteira Compartilhada atualizada com sucesso.');
    }

    public function destroy($id)
    {

        $walletSharedTo = WalletSharedTo::with('wallet')->findOrFail($id);

        // Ensure that the wallet belongs to the authenticated user
        if ($walletSharedTo->wallet && $walletSharedTo->wallet->id_owner != auth()->id()) {
            abort(403);
        }

        // Delete the walletshared entry
        $walletSharedTo->delete();

        return redirect()->route('walletshared.index')->with('success', 'Carteira Compartilhada excluída com sucesso.');
    }
}
