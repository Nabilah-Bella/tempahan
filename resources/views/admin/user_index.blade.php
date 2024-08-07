@extends('layouts.system')

@section('title')
<span>MANAGE USERS</span>
@endsection

@section('content')

<a href="{{ route('admin.user.create') }}" class="btn btn-primary">Add User</a>

<table class="table table-bordered">
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Role</th>
        <th>Action</th>
    </tr>
    <!-- @php($i = 0) -->
    @php($i = ($users->currentPage() - 1)* $users->perPage())
    @foreach($users as $user)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $user->name}}</td>
        <td>{{ $user->email}}</td>
        <td>{{ $user->phone}}</td>
        <td>{{ $user->role}}</td>
        <td>
            <form method="POST" action="{{ route('admin.user.destroy', $user->id) }}">
                <input type="hidden" name="_method" value="DELETE">
                @csrf
                <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </td>    
    </tr>
    @endforeach
</table>
{!! $users->render() !!}
@endsection