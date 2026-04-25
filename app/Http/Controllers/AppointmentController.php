<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['service', 'payment'])
            ->orderBy('appointment_date', 'desc')
            ->get();
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $services = Service::orderBy('name')->get();
        return view('appointments.form', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name'    => 'required|string|max:100',
            'customer_contact' => 'required|string|max:20',
            'customer_email'   => 'nullable|email|max:100',
            'service_id'       => 'required|exists:services,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'notes'            => 'nullable|string|max:500',
        ]);

        $datetime = $validated['appointment_date'] . ' ' . $validated['appointment_time'];
        unset($validated['appointment_date'], $validated['appointment_time']);
        $validated['appointment_date'] = $datetime;

        Appointment::create($validated);

        return redirect()->route('appointments.index')->with('success', 'Appointment booked successfully.');
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['service', 'payment']);
        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $services = Service::orderBy('name')->get();
        return view('appointments.form', compact('appointment', 'services'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'customer_name'    => 'required|string|max:100',
            'customer_contact' => 'required|string|max:20',
            'customer_email'   => 'nullable|email|max:100',
            'service_id'       => 'required|exists:services,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'notes'            => 'nullable|string|max:500',
        ]);

        $datetime = $validated['appointment_date'] . ' ' . $validated['appointment_time'];
        unset($validated['appointment_date'], $validated['appointment_time']);
        $validated['appointment_date'] = $datetime;

        $appointment->update($validated);

        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Appointment deleted.');
    }
}
