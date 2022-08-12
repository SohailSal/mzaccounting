@extends('base')
@section('main')
<div class="row">
<div class="col-sm-12">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div>
  @endif
    <h1 class="display-5">Transactions</h1>
    <div>
    <a style="margin: 5px;" href="{{ route('home')}}" class="btn btn-primary">Home</a>
    <a style="margin: 5px;" href="{{ route('transactions.create')}}" class="btn btn-primary">New Transaction</a>
    </div>
    <div>
    {{$transactions->links()}}
</div>
  <table class="table table-striped">
    <thead>
        <tr>
          <td>Ref</td>
          <td>Date of Transaction</td>
          <td>Description</td>
          <td colspan = 2 style="text-align:center;">Actions</td>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions as $transaction)
        <tr>
            <td>{{$transaction->ref}}</td>
            <td>{{$transaction->date_of_transaction}}</td>
            <td>{{$transaction->description}}</td>
            <td>
                <a href="{{ route('transactions.edit',$transaction->id)}}" class="btn btn-primary">Edit</a>
            </td>
            <td>
                <a href="{{ route('transactions.show',$transaction->id)}}" class="btn btn-info">Show</a>
          	</td>
        </tr>
        @endforeach
    </tbody>
  </table>
<div>
</div>
<div>
    {{$transactions->links()}}
</div>
@endsection
