@extends('layouts.app')

@section('content')
    <h1>Create Pet</h1>
    <form action="{{ route('pet.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" class="form-control" required>
                <option value="available">Available</option>
                <option value="pending">Pending</option>
                <option value="sold">Sold</option>
            </select>
        </div>
        <div class="form-group">
            <label for="photoUrls">Photo URLs:</label>
            <input type="text" name="photoUrls" class="form-control">
        </div>
        <div class="form-group">
            <label for="tags">Tags:</label>
            <input type="text" name="tags" class="form-control">
        </div>
        <div class="form-group">
            <label for="category">Category:</label>
            <input type="text" name="category" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endsection
