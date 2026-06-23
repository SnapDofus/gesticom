<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Http\Requests\StoreMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::where('user_id', Auth::id())->latest()->get();
        return view('materials.index', compact('materials'));
    }

    public function store(StoreMaterialRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $qtyPlanned = $data['quantity_planned'];
        $qtyPurchased = $data['quantity_purchased'];

        if ($qtyPurchased <= 0) {
            $data['status'] = 'not_purchased';
        } elseif ($qtyPurchased >= $qtyPlanned) {
            $data['status'] = 'fully_purchased';
        } else {
            $data['status'] = 'partially_purchased';
        }

        Material::create($data);

        return redirect()->route('materials.index')->with('success', 'Matériau ajouté avec succès.');
    }

    public function edit(Material $material)
    {
        $this->authorize('update', $material);
        return response()->json($material);
    }

    public function update(UpdateMaterialRequest $request, Material $material)
    {
        $this->authorize('update', $material);

        $data = $request->validated();

        $qtyPlanned = $data['quantity_planned'];
        $qtyPurchased = $data['quantity_purchased'];

        if ($qtyPurchased <= 0) {
            $data['status'] = 'not_purchased';
        } elseif ($qtyPurchased >= $qtyPlanned) {
            $data['status'] = 'fully_purchased';
        } else {
            $data['status'] = 'partially_purchased';
        }

        $material->update($data);

        return redirect()->route('materials.index')->with('success', 'Matériau modifié avec succès.');
    }

    public function destroy(Material $material)
    {
        $this->authorize('delete', $material);
        $material->delete();

        return redirect()->route('materials.index')->with('success', 'Matériau supprimé avec succès.');
    }

    public function markAsPurchased(Material $material)
    {
        $this->authorize('update', $material);

        $material->update([
            'quantity_purchased' => $material->quantity_planned,
            'status' => 'fully_purchased',
            'purchase_date' => now()->toDateString(),
        ]);

        return redirect()->route('materials.index')->with('success', 'Matériau marqué comme complètement acheté.');
    }

    public function stats()
    {
        $userId = Auth::id();
        $total = Material::where('user_id', $userId)->count();
        $purchased = Material::where('user_id', $userId)->where('status', 'fully_purchased')->count();
        $partial = Material::where('user_id', $userId)->where('status', 'partially_purchased')->count();
        $notPurchased = Material::where('user_id', $userId)->where('status', 'not_purchased')->count();

        return response()->json(compact('total', 'purchased', 'partial', 'notPurchased'));
    }
}
