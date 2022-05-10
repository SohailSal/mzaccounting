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
    <h1 class="display-5">Payment Voucher</h1>
  </div>
</div>

<form method="post" action="{{ route('payments.store') }}" class="prevent-multi">
 @csrf
<div class="row">
          <div class="form-group float-left">
              <label for="ref">Reference:</label>
              <input type="text" class="form-control reference" name="ref" value="{{$inv}}" readonly/>
          </div>
          <div class="form-group float-left">
              <label for="date_of_payment">Date of Payment:</label>
              <input type="text" class="form-control date" name="date_of_payment"/>
          </div>
</div>

<div class="row">
          <div class="form-group float-left">
              <label for="description">Description:</label>
              <textarea rows="2" class="form-control  rounded-0" name="description" id="description" >To record </textarea>
          </div>
</div>

<div class="row">
          <div class="form-group float-left">
              <label for="account_id">Account:</label>
                <select class="form-control" name="account_id" id="account_id" style="width:300px;">
                    <option value="">Select account</option>
                    @foreach (App\Account::all() as $item)
                        @if($item->client)
                        @continue
                        @endif
                    <option value="{{$item->id}}">{{$item->head_of_account}}</option>
                    @endforeach
                </select>
            </div>
    <div>
    <a style="margin: 19px;" href="{{ route('accounts.create')}}" class="btn btn-primary">New Head of Account</a>
    </div>

</div>

<div class="row">
          <div class="form-group float-left">
              <label for="mode">Mode of Payment:</label>
                <select class="form-control nowyouseeme" id="mode" name="mode">
    		    	<option value=''>Select mode of payment</option>
    		    	<option value='1'>Cash</option>
    		    	<option value='2'>Bank</option>
                </select>
          </div>
</div>

<div class="row hiding" style="display:none;">
            <div class="form-group float-left">
                <label for="cheque">Cheque #:</label>
                <input type="text" class="form-control" id="cheque" name="cheque" readonly/>
            </div>
            <div class="form-group float-left">
                <label for="stax">Payee:</label>
                <input type="text" class="form-control" id="payee" name="payee" readonly/>
            </div>
            <div class="form-group float-left">
                <label for="amount">Amount:</label>
                <input type="text" class="form-control" id="amount" name="amount" readonly/>
            </div>
 </div>


 <div class="row">
        <div class="float-right">
            <button type="submit" class="btn btn-primary prevent-multi-submit">Enter Payment</button>
        </div>
</div>

</form>
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


nfObject = new Intl.NumberFormat('en-US');

    $('.date').datepicker({
            autoclose: true,
            format: "dd-mm-yyyy",
            immediateUpdates: true,
            todayBtn: true,
            todayHighlight: true
        }).datepicker("setDate", "0");

    $(document).on("changeDate",".date", function(){
        var ref = $('.reference').val();
        var arr = ref.split('/');
        var arr2 = $(this).val().split('-');
        var result = arr[0]+"/"+arr[1]+"/"+arr[2]+"/"+Number(arr2[1])+"/"+arr[4];
        ref2 = result;
        $('.reference').val(ref2);
    });

    $(document).on("change",".nowyouseeme", function(){
        if($('#mode').val()=='1'){
        $('#cheque').prop('readonly',true);
        $('#payee').prop('readonly',true);
        $('#amount').removeAttr('readonly');
        $('.hiding').fadeIn('medium');
        }
        else if($('#mode').val()=='2'){
        $('#cheque').removeAttr('readonly');
        $('#payee').removeAttr('readonly');
        $('#amount').removeAttr('readonly');
        $('.hiding').fadeIn('medium');
        }
        else{
        $('#cheque').prop('readonly',true);
        $('#payee').prop('readonly',true);
        $('#amount').prop('readonly',true);
        $('.hiding').fadeIn('medium');
        }
    });

    $('.prevent-multi').on('submit', function(){
        $('.prevent-multi-submit').attr('disabled','true');
        return true;
    });

});

</script>
@endsection
