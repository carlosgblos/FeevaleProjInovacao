<?php

namespace App\Http\Controllers;

use App\Models\MovementType;
use Illuminate\Http\Request;

class MovementTypeController extends Controller
{
    public function index(Request $request)
    {
        $movementTypes = MovementType::ownedByUser()->paginate(10);

        return view('movement_type.index', compact('movementTypes'));
    }

    public function create()
    {
        return view('movement_type.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'nullable|string',
        ]);

        MovementType::create($request->all());

        return redirect()->route('movement_type.index')->with('success', 'Tipo de Movimento criado com sucesso.');
    }

    public function edit(MovementType $movementType)
    {
        if ($movementType->id_owner != auth()->id()) {
            abort(403);
        }

        return view('movement_type.edit', compact('movementType'));
    }

    public function update(Request $request, MovementType $movementType)
    {
        if ($movementType->id_owner != auth()->id()) {
            abort(403);
        }

        $request->validate([
            'description' => 'nullable|string',
        ]);

        $movementType->update($request->all());

        return redirect()->route('movement_type.index')->with('success', 'Tipo de Movimento atualizado com sucesso.');
    }

    public function destroy(MovementType $movementType)
    {
        if ($movementType->id_owner != auth()->id()) {
            abort(403);
        }

        $movementType->delete();

        return redirect()->route('movement_type.index')->with('success', 'Tipo de Movimento excluído com sucesso.');
    }
}
