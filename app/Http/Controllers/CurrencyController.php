<?php

// app/Http/Controllers/CurrencyController.php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all currenciesu
        $currencies = Currency::paginate(10);
        return view('currency.index', compact('currencies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('currency.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'description' => 'nullable|string',
            'abbreviation' => 'required|string|max:255',
        ]);

        // Create a new currency
        Currency::create($request->all());

        // Redirect to the index page with a success message
        return redirect()->route('currency.index')->with('success', 'Moeda Criada com Sucesso.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Currency $currency)
    {
        return view('currency.edit', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Currency $currency)
    {
        // Validate the input
        $request->validate([
            'description' => 'nullable|string',
            'abbreviation' => 'required|string|max:255',
        ]);

        // Update the currency
        $currency->update($request->all());

        // Redirect to the index page with a success message
        return redirect()->route('currency.index')->with('success', 'Moeda Alterada com Sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Currency $currency)
    {
        // Soft delete the currency
        $currency->delete();

        return redirect()->route('currency.index')->with('success', 'Moeda Removida com Sucesso.');
    }
}
