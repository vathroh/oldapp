@extends('layouts.app')

@section('content')
<form>
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection