@extends('base')
@section('main')

<form method="get" action="{{ action('EntryController@getLed') }}">
 @csrf
  <div class="row">
          <div class="form-group float-left">
              <label for="date_start">Start date:</label>
              <input type="text" class="form-control date" name="date_start"/>
          </div>
          <div class="form-group float-left">
              <label for="date_end">End date:</label>
              <input type="text" class="form-control date" name="date_end"/>
          </div>
          <div class="form-group float-left">
              <label for="account_id">Account:</label>
              <select class="form-control" name="account_id">
                  @foreach (App\Account::all() as $item)
                  <option value="{{$item->id}}">{{$item->head_of_account}}</option>
                  @endforeach
              </select>
          </div>
           <button type="submit" class="btn btn-primary">Get Ledger</button>
  </div>
</form>

<div class="row">
  <div class="col-sm-12">
      @if(session()->get('success'))
        <div class="alert alert-success">
          {{ session()->get('success') }}
        </div>
      @endif
        <h1 class="display-5">Entry</h1>
        <div>
        <a style="margin: 19px;" href="{{ route('entries.create')}}" class="btn btn-primary">New Entry</a>
        <a href="{{ action('EntryController@export')}}" class="btn btn-primary">Export Excel</a>
  <div>
    {{$entries->links()}}
</div>

<div>
    <table class="table table-striped">
    <thead>
        <tr>
          <td>Head of Account</td>
          <td>Transaction ID</td>
          <td>Debit</td>
          <td>Credit</td>
          <td colspan = 3 style="text-align:center;">Actions</td>
        </tr>
    </thead>
    <tbody>
        @foreach($entries as $entry)
        <tr>
            <td>{{$entry->account->head_of_account}}</td>
            <td>{{$entry->transaction_id}}</td>
            <td>{{$entry->debit}}</td>
            <td>{{$entry->credit}}</td>
            <td>
                <a href="{{ route('entries.show',$entry->id)}}" class="btn btn-info">Show</a>
          	</td>
            <td>
                <a href="{{ route('entries.edit',$entry->id)}}" class="btn btn-primary">Edit</a>
            </td>
            <td>
                <a href="{{action('EntryController@getTrial')}}">Trial Balance</a>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
</div>
<div>
    {{$entries->links()}}
</div>
@endsection


@section('script')
<script>
$(document).ready(function() {

    $(document).on("keydown", ":input:not(textarea):not(:submit)", function(event) {
    if(event.keyCode == 13) {
        event.preventDefault();
        return false;
        }
    });


    $('.date').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            immediateUpdates: true,
            todayBtn: true,
            todayHighlight: true
        }).datepicker("setDate", "0");

});

</script>

@endsection
