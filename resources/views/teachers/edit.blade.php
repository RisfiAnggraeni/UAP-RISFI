@extends('layout')
@section('content')
 
<div class="card">
  <div class="card-header">Edit Page</div>
  <div class="card-body">
      
  <form action="{{ url('teachers/' . $teacher->id) }}" method="post">
    {!! csrf_field() !!}
    @method("PATCH")
    <input type="hidden" name="id" value="{{ $teacher->id }}" />
    <label>Name</label><br>
    <input type="text" name="name" value="{{ $teacher->name }}" class="form-control"><br>
    <label>Address</label><br>
    <input type="text" name="address" value="{{ $teacher->address }}" class="form-control"><br>
    <label>Mobile</label><br>
    <input type="text" name="mobile" value="{{ $teacher->mobile }}" class="form-control"><br>
    <input type="submit" value="Update" class="btn btn-success"><br>
</form>
   
  </div>
</div>
 
@stop