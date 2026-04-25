@extends('layouts.app')
@section('title', isset($service) ? 'Edit Service' : 'Add Service')
@section('content')
<div class="card" style="max-width:600px;margin:0 auto;">
    <div class="card-title">{{ isset($service) ? 'Edit Service' : 'Add New Service' }}</div>

    @if($errors->any())
        <div class="errors">
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ isset($service) ? route('services.update', $service) : route('services.store') }}" method="POST">
        @csrf
        @if(isset($service)) @method('PUT') @endif

        <div class="form-group">
            <label>Service Name *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $service->name ?? '') }}" placeholder="e.g. Manicure, Pedicure, Gel Polish" required>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Price (₱) *</label>
                <input type="number" name="price" class="form-control" value="{{ old('price', $service->price ?? '') }}" placeholder="0.00" step="0.01" min="0" required>
            </div>
            <div class="form-group">
                <label>Duration *</label>
                <select name="duration" class="form-control" required>
                    <option value="">-- Select Duration --</option>
                    @foreach(['15 mins','30 mins','45 mins','1 hour','1.5 hours','2 hours','2.5 hours','3 hours'] as $d)
                        <option value="{{ $d }}" {{ old('duration', $service->duration ?? '') == $d ? 'selected' : '' }}>{{ $d }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Optional description...">{{ old('description', $service->description ?? '') }}</textarea>
        </div>
        <div style="display:flex;gap:10px;">
            <button type="submit" class="btn btn-primary">{{ isset($service) ? 'Update Service' : 'Add Service' }}</button>
            <a href="{{ route('services.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
