<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use App\Http\Requests\StoreWorkerRequest;
use App\Http\Requests\UpdateWorkerRequest;
use Illuminate\Support\Facades\Auth;

class WorkerController extends Controller
{
    public function index()
    {
        $workers = Worker::with('payments')->where('user_id', Auth::id())->latest()->get();
        return view('workers.index', compact('workers'));
    }

    public function store(StoreWorkerRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        Worker::create($data);

        return redirect()->route('workers.index')->with('success', 'Ouvrier ajouté avec succès.');
    }

    public function edit(Worker $worker)
    {
        $this->authorize('update', $worker);
        return response()->json($worker);
    }

    public function update(UpdateWorkerRequest $request, Worker $worker)
    {
        $this->authorize('update', $worker);
        $worker->update($request->validated());

        return redirect()->route('workers.index')->with('success', 'Ouvrier modifié avec succès.');
    }

    public function destroy(Worker $worker)
    {
        $this->authorize('delete', $worker);
        $worker->delete();

        return redirect()->route('workers.index')->with('success', 'Ouvrier supprimé avec succès.');
    }
}
