@extends('base')
@section('main')
<div class="row">
 <div class="col-sm-8 offset-sm-2">
    <h1 class="display-5">Add a Type of Account</h1>
  <div>
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
      <form method="post" action="{{ route('types.store') }}">
          @csrf
          <div class="form-group">    
              <label for="type_of_account">Type of Account:</label>
              <input type="text" class="form-control" name="type_of_account"/>
          </div>
          <button type="submit" class="btn btn-primary">Add Type</button>
      </form>
  </div>
</div>
</div>
@endsection