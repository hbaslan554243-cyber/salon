@extends('layouts.app')
@section('title', 'Appointments')
@section('content')
<div class="card">
    <div class="action-bar">
        <div class="card-title" style="margin:0;">Appointments</div>
        <a href="{{ route('appointments.create') }}" class="btn btn-primary">+ New Booking</a>
    </div>
    @if($appointments->isEmpty())
        <p style="color:#888;font-size:14px;margin-top:12px;">No appointments yet.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Contact</th>
                    <th>Service</th>
                    <th>Date & Time</th>
                    <th>Price</th>
                    <th>Payment</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appt)
                <tr>
                    <td>{{ $appt->id }}</td>
                    <td><strong>{{ $appt->customer_name }}</strong></td>
                    <td>{{ $appt->customer_contact }}</td>
                    <td>{{ $appt->service->name ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($appt->appointment_date)->format('M d, Y h:i A') }}</td>
                    <td>₱{{ number_format($appt->service->price ?? 0, 2) }}</td>
                    <td>
                        @if($appt->payment)
                            <span class="badge badge-{{ $appt->payment->status === 'paid' ? 'success' : 'danger' }}">
                                {{ ucfirst($appt->payment->status) }}
                            </span>
                        @else
                            <span class="badge badge-warning">Unpaid</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('appointments.show', $appt) }}" class="btn btn-secondary btn-sm">View</a>
                        <a href="{{ route('appointments.edit', $appt) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('appointments.destroy', $appt) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this appointment?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
