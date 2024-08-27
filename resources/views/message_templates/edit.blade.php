@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
    <div class="container">
        <h1>Edit Category</h1>
        <form action="{{ route('message-categories.update', $messageCategory) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ $messageCategory->title }}" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="1" {{ $messageCategory->status ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$messageCategory->status ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
@endsection
