@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-between">
        <h1>Pets</h1>
        <a href="{{ route('pet.create') }}" class="btn btn-primary">Create Pet</a>
    </div>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <ul class="list-group">
        @if ($pets && is_array($pets))
            @foreach ($pets as $pet)
                @if (is_array($pet) && isset($pet['id']) && isset($pet['name']))
                    <li class="list-group-item">
                        <a href="{{ route('pet.show', $pet['id']) }}">{{ $pet['name'] }}</a>
                        <span class="badge text-bg-info">{{$pet['status']}}</span>
                        <a href="{{ route('pet.edit', $pet['id']) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('pet.destroy', $pet['id']) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </li>
                @else
                    <li class="list-group-item">Invalid Pet Data</li>
                @endif
            @endforeach
        @else
            <li class="list-group-item">Brak danych lub nieprawidłowe dane</li>
        @endif
    </ul>
@endsection
