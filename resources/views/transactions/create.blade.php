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
    <h1 class="display-5">Journal Voucher</h1>
  </div>
</div>

<form method="post" action="{{ route('transactions.store') }}" class="prevent-multi">
 @csrf
<div class="row">
          <div class="form-group float-left">
              <label for="ref">Reference:</label>
              <input type="text" class="form-control reference" name="ref" value="{{$inv}}" readonly/>
          </div>
          <div class="form-group float-left">
              <label for="date_of_transaction">Date of Transaction:</label>
              <input type="text" class="form-control date" name="date_of_transaction"/>
          </div>
</div>

<div class="row">
          <div class="form-group float-left">
              <label for="description">Description:</label>
              <textarea rows="2" class="form-control  rounded-0" name="description"></textarea>
          </div>
</div>



<div class="input_fields_container_part">

    <div class="row">
            <div class="form-group float-left">
                <label for="account_id[]">Head of Account:</label>
                <select class="form-control" name="account_id[]" style="width:300px;">
                    @foreach (App\Account::all() as $item)
                    <option value="{{$item->id}}">{{$item->head_of_account}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group float-left">
                <label for="debit[]">Debit:</label>
                <input type="text" class="form-control debit" name="debit[]"/>
            </div>
            <div class="form-group float-left">
                <label for="credit[]">Credit:</label>
                <input type="text" class="form-control credit" name="credit[]"/>
            </div>
    </div>

    <div class="row">
            <div class="form-group float-left">
                <select class="form-control" name="account_id[]" style="width:300px;">
                    @foreach (App\Account::all() as $item)
                    <option value="{{$item->id}}">{{$item->head_of_account}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group float-left">
                <input type="text" class="form-control debit" name="debit[]"/>
            </div>
            <div class="form-group float-left">
                <input type="text" class="form-control credit" name="credit[]"/>
            </div>
    </div>


</div>

<div class="row" style="margin-left:10px">
            <div class="form-group float-left">
                <label for="result1">Difference:</label>
                <input type="text" class="form-control" name="result1" id="result1" readonly/>
            </div>
            <div class="form-group float-left">
                <label for="result2">Total:</label>
                <input type="text" class="form-control" name="result2" id="result2" readonly/>
            </div>
            <div class="form-group float-left">
                <label for="result3">Total:</label>
                <input type="text" class="form-control" name="result3" id="result3" readonly/>
            </div>
    </div>

<div class="row">
        <div class="float-right">
                <button class="btn btn-sm btn-primary add_more_button">Add More Fields</button>
                <button type="submit" class="btn btn-primary prevent-multi-submit" disabled>Add Transaction</button>
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

var x = 2;

html = '<div class="row">';
html+= '<div class="form-group float-left"><select class="form-control" name="account_id[]" style="width:300px;">';
html+= '@foreach (App\Account::all() as $item)<option value="{{$item->id}}">{{$item->head_of_account}}</option>';
html+= '@endforeach';
html+= '</select></div>';
html+= '<div class="form-group float-left"><input type="text" class="form-control debit" name="debit[]"/></div>';
html+= '<div class="form-group float-left"><input type="text" class="form-control credit" name="credit[]"/></div>';
html+= '<div class="form-group float-left"><a href="#" class="remove_field" style="margin-left:10px;">Remove</a></div></div>';

$('.add_more_button').click(function(e){
    e.preventDefault();
    x++;
    $('.input_fields_container_part').append(html);
    });

$('.input_fields_container_part').on("click",".remove_field", function(e){
    e.preventDefault(); $(this).parent('div').parent('div').remove();
    x--;
    reassign();
    })

$('.input_fields_container_part').on('blur','.debit',function(){
	var $c=$(this).parents('.row').find("input.credit");
	if (($(this).val() !== '') && ($c.val() !== '')) $c.val('');

    reassign();

	});

$('.input_fields_container_part').on('blur','.credit',function(){
	var $d=$(this).parents('.row').find("input.debit");
	if (($(this).val() !== '') && ($d.val() !== '')) $d.val('');

    reassign();

	});

    function reassign(){
    var ite=0;
    $('input[name="debit[]"]').each(function(){
        if($(this).val()=='') return true;
        ite = ite + parseInt($(this).val());
    });
    var ite2=0;
    $('input[name="credit[]"]').each(function(){
        if($(this).val()=='') return true;
        ite2 = ite2 + parseInt($(this).val());
    });
    $('#result2').val(ite);
    $('#result3').val(ite2);
    $('#result1').val($('#result2').val()-$('#result3').val());
    if($('#result1').val() != 0){
        $('#result1').css('color', 'red');
        $(':button[type="submit"]').prop('disabled',true);
    }
    else {
        $('#result1').css('color', 'green');
        $(':button[type="submit"]').prop('disabled',false);
    }
    }

    $('.prevent-multi').on('submit', function(){
        $('.prevent-multi-submit').attr('disabled','true');
        return true;
    });

});
</script>
@endsection
