@extends('base')
@section('main')
<div class="row">
<div class="col-sm-12">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div>
  @endif
    <h1 class="display-5">Types of Account</h1> 
    <div>
    <a style="margin: 19px;" href="{{ route('types.create')}}" class="btn btn-primary">New Type</a>
    </div>     
  <table class="table table-striped">
    <thead>
        <tr>
          <td>ID</td>
          <td>Types of Account</td>
          <td colspan = 3 style="text-align:center;">Actions</td>
        </tr>
    </thead>
    <tbody>
        @foreach($types as $type)
        <tr>
            <td>{{$type->id}}</td>
            <td>{{$type->type_of_account}}</td>
            <td>
                <a href="{{ route('types.show',$type->id)}}" class="btn btn-info">Show</a>
          	</td>
            <td>
                <a href="{{ route('types.edit',$type->id)}}" class="btn btn-primary">Edit</a>
            </td>
            <td>
                <form action="{{ route('types.destroy', $type->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" onclick="return confirm('Are you sure?')" type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
<div>
</div>
@endsection