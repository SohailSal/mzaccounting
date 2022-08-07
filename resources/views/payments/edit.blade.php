@extends('base')
@section('main')
<div class="row">
    <div class="col-sm-8 offset-sm-2">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <h1 class="display-5">Update a Payment</h1>
        <form method="post" action="{{ route('payments.update', $payment->id) }}">
            @method('PATCH')
            @csrf

            <div class="form-group">
                <label for="date_of_payment">Date of Payment:</label>
                <input type="text" class="form-control date" name="date_of_payment"/>
            </div>

            <div class="form-group">
              <label for="account_id">Head of Account:</label>
              <select class="form-control" name="account_id">
                  @foreach (App\Account::all() as $item)
                    <option value="{{$item->id}}" {{$item->id == $payment->account_id ? 'selected':''}}> {{$item->head_of_account}} </option>
                  @endforeach
              </select>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
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
            format: "dd-mm-yyyy",
            immediateUpdates: true,
            todayBtn: true,
            todayHighlight: true
        }).datepicker("setDate", "<?php echo $payment->date_of_payment ?>");

});


</script>

@endsection
