@extends('base')
@section('main')
<div class="row">
<div class="col-sm-12">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div>
  @endif
    <h1 class="display-5">List of Clients</h1>
    <div>
    <a style="margin: 5px;" href="{{ route('home')}}" class="btn btn-primary">Home</a>
    <a style="margin: 5px;" href="{{ route('clients.create')}}" class="btn btn-primary">New Client</a>
    <form method="get" action="{{ route('clients.index') }}">
      @csrf
      <div class="float-right btn-group">
        <input type="text" class="form-control" name="search" value="{{$search}}"/>
        <button class="btn btn-sm btn-primary search">Search</button>
      </div>
    </form>
    </div>
    <div>
    {{$clients->links()}}
</div>
  <table class="table table-striped">
    <thead>
        <tr>
          <td>ID</td>
          <td>Name of Client</td>
          <td>Type of Client</td>
          <td colspan = 4 style="text-align:center;">Actions</td>
        </tr>
    </thead>
    <tbody>
        @foreach($clients as $client)
        <tr>
            <td>{{$client->id}}</td>
            <td>{{$client->head_of_account}}
            </td>
            <td>
                @foreach($types as $type)
                @if($client->clienttype_id == $type->id)
                {{$type->type_of_client}}
                @endif
                @endforeach
            </td>
            <td>
                <a href="{{ route('clients.show',$client->id)}}" class="btn btn-primary">Show</a>
          	</td>
            <td>
                <a href="{{ route('clients.edit',$client->id)}}" class="btn btn-primary">Edit</a>
            </td>
            <td>
               <a href="{{action('AccountController@getLedger2', $client->ac_id)}}">Ledger in PDF</a>
            </td>

            <td>
               <a href="{{action('ClientController@envelop', $client->id)}}">Envelop</a>
            </td>

            <td>
                <form action="{{ route('clients.destroy', $client->id)}}" method="post">
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
<div>
    {{$clients->links()}}
</div>
@endsection
