@extends('base')
@section('main')

<br>
<h2>Trial Balance</h2>

<!-- <div class="row">
<a class="btn btn-outline-secondary" href="{{action('EntryController@getTrial')}}">Trial Balance</a>
</div>

<br> -->
<form method="get" action="{{ action('EntryController@getTriall') }}">
 @csrf
  <div class="row">
          <div class="form-group float-left">
              <label for="enddate">End date:</label>
              <input type="text" class="form-control date" name="enddate"/>
          </div>
          <div class="form-group float-left">
              <label for="submit">&nbsp;</label>
              <button type="submit" class="form-control btn btn-primary" name="submit">Trial Balance</button>
          </div>
  </div>
</form>

<form method="get" action="{{ action('EntryController@getTrialll') }}">
 @csrf
  <div class="row">
          <div class="form-group float-left">
              <label for="date_start">Start date:</label>
              <input type="text" class="form-control date" name="startdate"/>
          </div>
          <div class="form-group float-left">
              <label for="enddate">End date:</label>
              <input type="text" class="form-control date" name="enddate"/>
          </div>
          <div class="form-group float-left">
              <label for="submit">&nbsp;</label>
              <button type="submit" class="form-control btn btn-primary" name="submit">Trial Balance</button>
          </div>
  </div>
</form>

<br>
<h2>Date-wise Ledger</h2>


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
              <select class="form-control" name="account_id" style="width:300px">
                  @foreach (App\Account::all() as $item)
                  <option value="{{$item->id}}">{{$item->head_of_account}}</option>
                  @endforeach
              </select>
          </div>
          <div class="form-group float-left">
              <label for="submit">&nbsp;</label>
              <button type="submit" class="form-control btn btn-primary" name="submit">Get Ledger</button>
          </div>
  </div>
</form>

<br>
<h2>Date-wise Receipts</h2>


<form method="get" action="{{ action('ReceiptController@getReceiptsRange') }}">
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
              <label for="submit">&nbsp;</label>
              <button type="submit" class="form-control btn btn-primary" name="submit">Get Receipts</button>
          </div>
  </div>
</form>

<br>
<h2>Date-wise Payments</h2>


<form method="get" action="{{ action('PaymentController@getPaymentsRange') }}">
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
              <label for="submit">&nbsp;</label>
              <button type="submit" class="form-control btn btn-primary" name="submit">Get Payments</button>
          </div>
  </div>
</form>

<div class="row">
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
