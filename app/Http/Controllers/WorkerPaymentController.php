<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use App\Models\WorkerPayment;
use App\Http\Requests\StoreWorkerPaymentRequest;
use Illuminate\Support\Facades\Auth;

class WorkerPaymentController extends Controller
{
    public function index(Worker $worker)
    {
        $this->authorize('view', $worker);
        $payments = $worker->payments()->latest()->get();
        return view('workers.payments', compact('worker', 'payments'));
    }

    public function store(StoreWorkerPaymentRequest $request, Worker $worker)
    {
        $this->authorize('update', $worker);

        $data = $request->validated();
        $data['worker_id'] = $worker->id;
        $data['user_id'] = Auth::id();

        WorkerPayment::create($data);

        return redirect()->route('workers.payments', $worker)->with('success', 'Paiement ajouté avec succès.');
    }

    public function destroy(Worker $worker, WorkerPayment $payment)
    {
        $this->authorize('delete', $payment);
        $payment->delete();

        return redirect()->route('workers.payments', $worker)->with('success', 'Paiement supprimé avec succès.');
    }
}
