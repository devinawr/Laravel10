<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $transactions = Transaction::with('services')->latest()->get();
        //$transactions = DB::table('transaction')->get();
        return view('transactions.index', compact('transactions'));
    }

    public function getEditFormB(Request $request)
    {
        $transaction = Transaction::findOrFail($request->id);
        $doctors = Doctor::all();
        $users = User::all();

        return response()->json([
            'status' => 'oke',
            'msg' => view('transactions.getEditFormB', compact('transaction', 'doctors', 'users'))->render()
        ], 200);
    }

    public function saveDataUpdate(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:transaction,id',
            'user_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:doctors,id',
            'service_type' => 'required|string|max:255',
            'transaction_date' => 'required|date_format:Y-m-d\TH:i',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $transaction = Transaction::findOrFail($validated['id']);
        $transaction->update([
            'user_id' => $validated['user_id'],
            'doctor_id' => $validated['doctor_id'],
            'service_type' => $validated['service_type'],
            'transaction_date' => $validated['transaction_date'],
            'amount' => $validated['amount'],
            'status' => $validated['status'],
        ]);

        return response()->json([
            'status' => 'oke',
            'msg' => 'Transaction updated successfully.'
        ], 200);
    }

    public function deleteData(Request $request)
    {
        try {
            $transaction = Transaction::findOrFail($request->id);
            $transaction->delete();

            return response()->json([
                'status' => 'oke',
                'msg' => 'Transaction removed successfully.'
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Unable to delete transaction.'
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::all();
        return view('transactions.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {$validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:doctors,id',
            'transaction_date' => 'required|date_format:Y-m-d\TH:i',
            'status' => 'required|in:pending,completed,cancelled',
            'services' => 'required|array',
            'services.*' => 'exists:services,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
        ]);

        $serviceIds = $validated['services'];
        $quantities = $validated['quantities'];
        $totalAmount = 0;
        $services = [];

        foreach ($serviceIds as $index => $serviceId) {
            $service = Service::find($serviceId);
            $qty = $quantities[$index] ?? 1;
            $totalAmount += $service->price * $qty;
            $services[] = $service;
        }

        if (count($services) === 1) {
            $serviceType = $services[0]->service_name;
        } else {
            $serviceType = 'multiple_services';
        }

        $transaction = Transaction::create([
            'user_id' => $validated['user_id'],
            'doctor_id' => $validated['doctor_id'],
            'service_type' => $serviceType,
            'transaction_date' => $validated['transaction_date'],
            'amount' => $totalAmount,
            'status' => $validated['status'],
        ]);

        $syncData = [];
        foreach ($serviceIds as $index => $serviceId) {
            $qty = $quantities[$index] ?? 1;
            $syncData[$serviceId] = ['qty' => $qty];
        }
        
        $transaction->services()->sync($syncData);

        return redirect()->route('transactions.index')->with('success', 'Transaction created successfully!');
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $transaction = Transaction::find($id);
        if (!$transaction) {
            return redirect()->route('transactions.index')->with('error', 'Transaction not found.');
        }
        $services = Service::all();
        $transactionServices = $transaction->services()->get();
        return view('transactions.edit', compact('transaction', 'services', 'transactionServices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $transaction = Transaction::find($id);
        if (!$transaction) {
            return redirect()->route('transactions.index')->with('error', 'Transaction not found.');
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:doctors,id',
            'transaction_date' => 'required|date_format:Y-m-d\TH:i',
            'status' => 'required|in:pending,completed,cancelled',
            'services' => 'required|array',
            'services.*' => 'exists:services,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
        ]);

        $serviceIds = $validated['services'];
        $quantities = $validated['quantities'];
        $totalAmount = 0;
        $services = [];

        foreach ($serviceIds as $index => $serviceId) {
            $service = Service::find($serviceId);
            $qty = $quantities[$index] ?? 1;
            $totalAmount += $service->price * $qty;
            $services[] = $service;
        }

        if (count($services) === 1) {
            $serviceType = $services[0]->service_name;
        } else {
            $serviceType = 'multiple_services';
        }

        $transaction->update([
            'user_id' => $validated['user_id'],
            'doctor_id' => $validated['doctor_id'],
            'service_type' => $serviceType,
            'transaction_date' => $validated['transaction_date'],
            'amount' => $totalAmount,
            'status' => $validated['status'],
        ]);

        $syncData = [];
        foreach ($serviceIds as $index => $serviceId) {
            $qty = $quantities[$index] ?? 1;
            $syncData[$serviceId] = ['qty' => $qty];
        }
        
        $transaction->services()->sync($syncData);

        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaction = Transaction::find($id);
        if (!$transaction) {
            return redirect()->route('transactions.index')->with('error', 'Transaction not found.');
        }

        $transaction->delete();
        
        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully!');
    }
}