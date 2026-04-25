<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['appointment.service'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('payments.index', compact('payments'));
    }

    public function create(Request $request)
    {
        $appointments = Appointment::with('service')
            ->orderBy('appointment_date', 'desc')
            ->get();
        $selectedId = $request->query('appointment_id');
        return view('payments.form', compact('appointments', 'selectedId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'amount_paid'    => 'required|numeric|min:0',
            'payment_method' => 'nullable|string|max:50',
            'status'         => 'required|in:paid,unpaid',
            'paid_at'        => 'nullable|date',
            'notes'          => 'nullable|string|max:500',
        ]);

        if ($validated['status'] === 'paid' && empty($validated['paid_at'])) {
            $validated['paid_at'] = now();
        }
        if ($validated['status'] === 'unpaid') {
            $validated['paid_at'] = null;
        }

        Payment::create($validated);

        return redirect()->route('payments.index')->with('success', 'Payment recorded successfully.');
    }

    public function edit(Payment $payment)
    {
        $appointments = Appointment::with('service')
            ->orderBy('appointment_date', 'desc')
            ->get();
        return view('payments.form', compact('payment', 'appointments'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'amount_paid'    => 'required|numeric|min:0',
            'payment_method' => 'nullable|string|max:50',
            'status'         => 'required|in:paid,unpaid',
            'paid_at'        => 'nullable|date',
            'notes'          => 'nullable|string|max:500',
        ]);

        if ($validated['status'] === 'paid' && empty($validated['paid_at'])) {
            $validated['paid_at'] = now();
        }
        if ($validated['status'] === 'unpaid') {
            $validated['paid_at'] = null;
        }

        $payment->update($validated);

        return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Payment deleted.');
    }
}
