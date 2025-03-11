@extends('layouts.app')

@section('content')
    <h1>Edit Pet</h1>
    <form action="{{ route('pet.update', $pet['id']) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{ $pet['id'] }}">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" class="form-control" value="{{ $pet['name'] }}" required>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" class="form-control" required>
                <option value="available" {{ $pet['status'] === 'available' ? 'selected' : '' }}>Available</option>
                <option value="pending" {{ $pet['status'] === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="sold" {{ $pet['status'] === 'sold' ? 'selected' : '' }}>Sold</option>
            </select>
        </div>
        <div class="form-group">
            <label for="photoUrls">Photo URLs:</label>
            <input type="text" name="photoUrls" class="form-control"
                value="{{ isset($pet['photoUrls']) ? implode(',', $pet['photoUrls']) : '' }}">
        </div>
        <div class="form-group">
            <label for="tags">Tags:</label>
            <input type="text" name="tags" class="form-control"
                value="{{ isset($pet['tags']) ? implode(',', array_column($pet['tags'], 'name')) : '' }}">
        </div>
        <div class="form-group">
            <label for="category">Category:</label>
            <input type="text" name="category" class="form-control"
                value="{{ isset($pet['category']) ? $pet['category']['name'] : '' }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
    <a href="{{ route('pet.index') }}" class="btn btn-secondary">Back to List</a>
    <form action="{{ route('pet.destroy', $pet['id']) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this pet?')">
            Delete
        </button>
    </form>
@endsection
