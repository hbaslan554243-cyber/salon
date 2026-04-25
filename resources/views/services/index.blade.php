@extends('layouts.app')
@section('title', 'Services')
@section('content')
<div class="card">
    <div class="action-bar">
        <div class="card-title" style="margin:0;">Salon Services</div>
        <a href="{{ route('services.create') }}" class="btn btn-primary">+ Add Service</a>
    </div>
    @if($services->isEmpty())
        <p style="color:#888;font-size:14px;margin-top:12px;">No services found. Add your first service!</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Service Name</th>
                    <th>Price</th>
                    <th>Duration</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($services as $service)
                <tr>
                    <td>{{ $service->id }}</td>
                    <td><strong>{{ $service->name }}</strong></td>
                    <td>₱{{ number_format($service->price, 2) }}</td>
                    <td>{{ $service->duration }}</td>
                    <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $service->description ?: '-' }}</td>
                    <td>
                        <a href="{{ route('services.edit', $service) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('services.destroy', $service) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this service?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
