@extends('base')
@section('main')
<div class="row">
<div class="col-sm-12">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div>
  @endif
    <h1 class="display-5">Invoices</h1>
    <div>
    <a style="margin: 5px;" href="{{ route('home')}}" class="btn btn-primary">Home</a>
    <a style="margin: 5px;" href="{{ route('invoices.create')}}" class="btn btn-primary">New Invoice</a>
    <a style="margin: 5px;" href="{{action('InvoiceController@unpaid')}}" class="btn btn-primary">Unpaid Invoices</a>
    <form method="get" action="{{ route('invoices.index') }}">
      @csrf
      <div class="float-right btn-group">
        <input type="text" class="form-control" name="search" value="{{$search}}"/>
        <button class="btn btn-sm btn-primary search">Search</button>
      </div>
    </form>
    </div>
<div>
    {{$invoices->links()}}
</div>
  <table class="table table-striped">
    <thead>
        <tr>
          <td>Ref</td>
          <td>Date of Invoice</td>
          <td>Account ID</td>
          <td colspan = 4 style="text-align:center;">Actions</td>
        </tr>
    </thead>
    <tbody>
        @foreach($invoices as $invoice)
        <tr>
            <td>{{$invoice->ref}}</td>
            <td>{{$invoice->date_of_invoice}}</td>
            <td>{{$invoice->account->head_of_account}}</td>
            <td>
                <a href="{{ route('invoices.show',$invoice->id)}}" class="btn btn-info">Show</a>
          	</td>
            <td>
                <a href="{{action('InvoiceController@downloadPDF', $invoice->id)}}">Generate Invoice PDF</a>
            </td>
            <td>
                <form action="{{ route('invoices.destroy', $invoice->id)}}" method="post">
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
    {{$invoices->links()}}
</div>
@endsection
