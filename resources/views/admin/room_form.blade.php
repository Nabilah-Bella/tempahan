@extends('layouts.system')

@section('title')
<span>ROOM INFORMATION</span>
@endsection

@section('content')
@if($room->id)
    @php($route = route('admin.room.update', $room->id))
    @php($method = 'PUT')
@else
    @php($route = route('admin.room.store'))
    @php($method = 'POST')
@endif
<form method="POST" action="{{ $route }}" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="{{ $method }}">
    @csrf
    <div class="mb-3">
        <label for="">Room Name</label>
        <input type="text" class="form-control" name="name" id="" value="{{ old('name', $room->name) }}">
        @error('name')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="">Description</label>
        <textarea class="form-control" name="description" id="" value="{{ old('description',  $room->description) }}"></textarea>
        @error('description')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="">Room Size</label>
        <input type="text" class="form-control" name="size" id="" value="{{ old('size',  $room->size) }}">
        @error('size')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="">Photo</label>
        <input type="file" class="form-control" name="photo" id="">
        @error('photo')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="">Status</label>
        <select class="form-control" name="status" id="">
            <option @if(old('status', $room->status) == '0') selected @endif value="0">Inactive</option>
            <option @if(old('status', $room->status) == '1') selected @endif value="1">Active</option>
        </select>
        @error('status')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
@endsection