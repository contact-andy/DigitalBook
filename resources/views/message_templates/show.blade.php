@extends('layouts.app')

@section('title', 'Category Details')

@section('content')
    <div class="container">
        <h1>Category Details</h1>
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td>{{ $messageCategory->id }}</td>
            </tr>
            <tr>
                <th>Title</th>
                <td>{{ $messageCategory->title }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $messageCategory->status ? 'Active' : 'Inactive' }}</td>
            </tr>
            <tr>
                <th>Created By</th>
                <td>{{ $messageCategory->created_by }}</td>
            </tr>
            <tr>
                <th>Updated By</th>
                <td>{{ $messageCategory->updated_by }}</td>
            </tr>
        </table>
        <a href="{{ route('message-categories.index') }}" class="btn btn-primary">Back to List</a>
    </div>
@endsection
