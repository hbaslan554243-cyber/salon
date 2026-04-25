@extends('layouts.app')
@section('title', 'Payments')
@section('content')
<div class="card">
    <div class="action-bar">
        <div class="card-title" style="margin:0;">Payment Records</div>
        <a href="{{ route('payments.create') }}" class="btn btn-primary">+ Record Payment</a>
    </div>
    @if($payments->isEmpty())
        <p style="color:#888;font-size:14px;margin-top:12px;">No payment records yet.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Service</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th>Date Paid</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $pay)
                <tr>
                    <td>{{ $pay->id }}</td>
                    <td>{{ $pay->appointment->customer_name ?? '-' }}</td>
                    <td>{{ $pay->appointment->service->name ?? '-' }}</td>
                    <td>₱{{ number_format($pay->amount_paid, 2) }}</td>
                    <td>{{ $pay->payment_method ? ucfirst($pay->payment_method) : '-' }}</td>
                    <td>
                        <span class="badge badge-{{ $pay->status === 'paid' ? 'success' : 'danger' }}">
                            {{ ucfirst($pay->status) }}
                        </span>
                    </td>
                    <td>{{ $pay->paid_at ? \Carbon\Carbon::parse($pay->paid_at)->format('M d, Y') : '-' }}</td>
                    <td>
                        <a href="{{ route('payments.edit', $pay) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('payments.destroy', $pay) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this payment?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top:16px;font-size:14px;color:#555;">
            <strong>Total Revenue (Paid):</strong>
            ₱{{ number_format($payments->where('status','paid')->sum('amount_paid'), 2) }}
        </div>
    @endif
</div>
@endsection
