@extends('layouts.app')

@section('content')
    <h1>Pet</h1>
    @if ($pet)
        <p><strong>ID:</strong> {{ $pet['id'] }}</p>
        <p><strong>Name:</strong> {{ $pet['name'] }}</p>
        <p><strong>Status:</strong> {{ $pet['status'] }}</p>
        @if (isset($pet['photoUrls']))
            <p><strong>Photo URLs:</strong> {{ implode(', ', $pet['photoUrls']) }}</p>
        @endif
        @if (isset($pet['tags']))
            <p><strong>Tags:</strong> {{ implode(', ', array_column($pet['tags'], 'name')) }}</p>
        @endif
        @if (isset($pet['category']))
            <p><strong>Category:</strong> {{ $pet['category']['name'] }}</p>
        @endif
    @else
        <p>Pet not found.</p>
    @endif
    <a href="{{ route('pet.index') }}" class="btn btn-secondary">Back to List</a>
    <a href="{{ route('pet.edit', $pet['id']) }}" class="btn btn-primary">Edit</a>
    <form action="{{ route('pet.destroy', $pet['id']) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this pet?')">
            Delete
        </button>
    </form>
@endsection
