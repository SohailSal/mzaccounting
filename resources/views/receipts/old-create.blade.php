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
    <h1 class="display-5">Receipt Voucher</h1>
  </div>
</div>

<form method="post" action="{{ route('receipts.store') }}">
 @csrf
<div class="row">
          <div class="form-group float-left">
              <label for="ref">Reference:</label>
              <input type="text" class="form-control reference" name="ref" value="{{$inv}}" readonly/>
          </div>
          <div class="form-group float-left">
              <label for="date_of_receipt">Date of Receipt:</label>
              <input type="text" class="form-control date" name="date_of_receipt"/>
          </div>
</div>

<div class="row">
          <div class="form-group float-left">
              <label for="description">Description:</label>
              <textarea rows="2" class="form-control  rounded-0" name="description" id="description" >To record the receipt from client.</textarea>
          </div>
</div>

<div class="row">
          <div class="form-group float-left">
              <label for="account_id">Client:</label>
                <select class="form-control" name="account_id" id="account_id">
                    <option value="">-- Select Client here --</option>
                    @foreach (App\Account::all() as $item)
                        @if(!$item->client)
                        @continue
                        @endif
                    <option value="{{$item->id}}">{{$item->head_of_account}}</option>
                    @endforeach
                </select>
          </div>
          <div class="form-group float-left">
              <label for="invoice_id">Invoice:</label>
                <select class="form-control" id="inv" name="invoice_id">
    		    	<option value=''>Please choose client first</option>
                </select>
          </div>
</div>

<div class="row">
            <div class="form-group float-left">
                <label for="amount">Cheque amount:</label>
                <input type="text" class="form-control" id="amount" name="amount"/>
            </div>
          <div class="form-group float-left">
              <label for="rate">Rate of ITax:</label>
                <select class="form-control" id="rate" name="rate">
                    <option value="10">10%</option>
                    <option value="8">8%</option>
                </select>
          </div>
          <div class="form-group float-left">
              <label for="strate">STax withheld by client:</label>
                <select class="form-control" id="strate" name="strate">
                    <option value="no" selected>No</option>
                    <option value="yes">Yes</option>
                </select>
          </div>
 </div>


<div class="row">
            <div class="form-group float-left">
                <label for="itax">ITax deducted by client:</label>
                <input type="text" class="form-control" id="itax" name="itax" readonly/>
            </div>
            <div class="form-group float-left">
                <label for="stax">Sales Tax deducted by client:</label>
                <input type="text" class="form-control" id="stax" name="stax" readonly/>
            </div>
            <div class="form-group float-left">
                <label for="gross">Gross amount:</label>
                <input type="text" class="form-control" id="gross" name="gross" readonly/>
            </div>

 </div>


 <div class="row">
        <div class="float-right">
                <button type="submit" class="btn btn-primary">Add Receipt</button>
        </div>
</div>

</form>
@endsection

@section('script')
<script>
$(document).ready(function() {

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

 nfObject = new Intl.NumberFormat('en-US');

    $('#account_id').on('change', function() {
        var stateID = $(this).val();
        if(stateID) {
            $.ajax({
                url: '/findInvoices/'+stateID,
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                dataType: "json",
                success:function(data) {
     //               console.log(data);
                    if(data){
                    $('#inv').empty();
                    $('#inv').focus;
                    $('#inv').append('<option value="">-- Select invoice --</option>');
                    $.each(data, function(key, value){
                    $('#inv').append('<option value="'+ value.id +'">' + value.ref+ ' - Dated: '+ value.date_of_invoice+ ' - Amount: '+ nfObject.format(value.amount)+'</option>');
  //                $('select[name="invoice_id"]').append('<option value="'+ value.id +'">' + value.ref+ ' - Dated: '+ value.date_of_invoice+ ' - Amount: '+ nfObject.format(value.amount)+'</option>');
                    $('#description').val('Receipt from '+$("#account_id option:selected").html());
                });
                }else{
                $('#inv').empty();
                }
                }
            });
        }else{
            $('#inv').empty();
        }
    });

    $('#amount,#rate,#strate').change(reassign);

    function reassign(){
        var amount = parseFloat($('#amount').val());
        var rate = $('#rate').val();
        var strate = $('#strate').val();
        var gross = 0;
        var sales = 0;
        var itax = 0;
        var stax = 0;
        var salestax = 0;
        if(!amount>0){
        return;
        }
        else if(rate == "8" && strate=="no"){
        gross = (amount/0.92);
        itax = (gross*0.08);
        $('#itax').val(itax);
        $('#stax').val('');
        $('#gross').val(gross);
        }
        else if(rate == "8" && strate=="yes"){
        gross = (amount/0.9776);
        sales = (gross*0.08);
        gross = gross + sales;
        itax = (gross*0.08);
        salestax = (sales*0.2);
        $('#itax').val(itax);
        $('#stax').val(salestax);
        $('#gross').val(gross);
        }
        else if(rate == "10" && strate=="yes"){
        gross = (amount/0.956);
        sales = (gross*0.08);
        gross = gross + sales;
        itax = (gross*0.1);
        salestax = (sales*0.2);
        $('#itax').val(itax);
        $('#stax').val(salestax);
        $('#gross').val(gross);
        }
        else{
        gross = (amount/0.9);
        itax = (gross*0.1);
        $('#itax').val(itax);
        $('#stax').val('');
        $('#gross').val(gross);
        }
    }

    $('#itax').on('click', function(){
        $(this).removeAttr('readonly');
    });

    $('#itax').on('change', function(){
        if($(this).val() == ''){
            $('#gross').val($('#amount').val());
        }
    });

});

</script>
@endsection
