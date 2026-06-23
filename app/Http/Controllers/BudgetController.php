<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Http\Requests\UpdateBudgetRequest;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function index()
    {
        $budgets = Budget::where('user_id', Auth::id())->get();
        $global = $budgets->where('category', 'global')->first();

        return view('budgets.index', compact('budgets', 'global'));
    }

    public function update(UpdateBudgetRequest $request, Budget $budget)
    {
        $this->authorize('update', $budget);
        $budget->update($request->validated());

        return redirect()->route('budgets.index')->with('success', 'Budget mis à jour avec succès.');
    }
}
