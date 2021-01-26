@extends('base')
@section('main')
<div class="row">
<div class="col-sm-12">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div>
  @endif
    <h1 class="display-5">Heads of Account</h1>
    <div>
    <a style="margin: 19px;" href="{{ route('home')}}" class="btn btn-primary">Home</a>
    <a style="margin: 19px;" href="{{ route('accounts.create')}}" class="btn btn-primary">New Head of Account</a>
    </div>
    <div>
    {{$accounts->links()}}
</div>
  <table class="table table-striped">
    <thead>
        <tr>
          <td>ID</td>
          <td>Head of Account</td>
          <td>Type of Account</td>
          <td colspan = 3 style="text-align:center;">Actions</td>
        </tr>
    </thead>
    <tbody>
        @foreach($accounts as $account)
        @if($account->client)
        @continue
        @endif
        <tr>
            <td>{{$account->id}}</td>
            <td>{{$account->head_of_account}}</td>
            <td>{{$account->type->type_of_account}}</td>
            <td>
                <a href="{{ route('accounts.show',$account->id)}}" class="btn btn-info">Show</a>
          	</td>
            <td>
                <a href="{{ route('accounts.edit',$account->id)}}" class="btn btn-primary">Edit</a>
            </td>
            <td>
                <a href="{{action('AccountController@getLedger2', $account->id)}}">Ledger in PDF</a>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
<div>
</div>
<div>
    {{$accounts->links()}}
</div>
@endsection
