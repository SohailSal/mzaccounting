@extends('base')
@section('main')
<div class="row">
<div class="col-sm-12">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div>
  @endif
    <h1 class="display-5">Entry</h1>
    <div>
    <a style="margin: 5px;" href="{{ route('invoiceentries.create')}}" class="btn btn-primary">New Entry</a>
    </div>
  <table class="table table-striped">
    <thead>
        <tr>
          <td>Invoice ID</td>
          <td>Description</td>
          <td>Amount</td>
          <td colspan = 3 style="text-align:center;">Actions</td>
        </tr>
    </thead>
    <tbody>
        @foreach($entries as $entry)
        <tr>
            <td>{{$entry->invoice_id}}</td>
            <td>{{$entry->description}}</td>
            <td>{{$entry->amount}}</td>
            <td>
                <a href="{{ route('invoiceentries.show',$entry->id)}}" class="btn btn-info">Show</a>
          	</td>
            <td>
                <a href="{{ route('invoiceentries.edit',$entry->id)}}" class="btn btn-primary">Edit</a>
            </td>
            <td>
                <form action="{{ route('invoiceentries.destroy', $entry->id)}}" method="post">
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
