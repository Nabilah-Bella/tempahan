@extends('layouts.system')

@section('title')
<span>USER INFORMATION</span>
@endsection

@section('content')
@if($user->id)
    @php($route = route('admin.user.update', $user->id))
    @php($method = 'PUT')
@else
    @php($route = route('admin.user.store'))
    @php($method = 'POST')
@endif
<form method="POST" action="{{ $route }}">
    <input type="hidden" name="_method" value="{{ $method }}">
    @csrf
    <div class="mb-3">
        <label for="">Name</label>
        <input type="text" class="form-control" name="name" id="" value="{{ old('name', $user->name) }}">
        @error('name')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="">Email</label>
        <input type="text" class="form-control" name="email" id="" value="{{ old('email',  $user->email) }}">
        @error('email')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="">Phone</label>
        <input type="text" class="form-control" name="phone" id="" value="{{ old('phone',  $user->phone) }}">
    </div>

    <div class="mb-3">
        <label for="">Role</label>
        <select class="form-control" name="role" id="">
            <option @if(old('role', $user->role) == 'user') selected @endif value="user">User</option>
            <option @if(old('role', $user->role) == 'admin') selected @endif value="admin">Admin</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="">Password</label>
        <input type="text" class="form-control" name="password" id="" value="">
        @error('password')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="">Confirm Password</label>
        <input type="text" class="form-control" name="password_confirmation" id="" value="">
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
@endsection