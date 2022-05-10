@extends('base')
@section('main')
<div class="row">
 <div class="col-sm-8">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div>
    @endif
    <h1 class="display-6">Enter an Invoice</h1>
  </div>
</div>

<form method="post" action="{{ route('invoices.store') }}" class="prevent-multi">
 @csrf
<div class="row">
          <div class="form-group float-left">
              <label for="ref">Reference:</label>
          <input type="text" class="form-control reference" name="ref" value="{{$inv}}" readonly/>
          </div>
          <div class="form-group float-left">
              <label for="date_of_invoice">Date of Invoice:</label>
              <input type="text" class="form-control date" name="date_of_invoice"/>
          </div>
</div>

<div class="row">
          <div class="form-group float-left">
              <label for="account_id">Client:</label>
              <select class="form-control" name="account_id" style="width:300px;">
                  @foreach (App\Account::all() as $item)
                    @if(!$item->client)
                    @continue
                    @endif
                  <option value="{{$item->id}}">{{$item->head_of_account}}</option>
                  @endforeach
              </select>
          </div>
          <div class="form-group float-left">
              <label for="income_id">Department:</label>
              <select class="form-control" name="income_id">
                  @foreach (App\Account::all() as $item)
                    @if(!($item->type->type_of_account == "Income"))
                    @continue
                    @endif
                  <option value="{{$item->id}}">{{$item->head_of_account}}</option>
                  @endforeach
              </select>
          </div>
</div>


<div class="input_fields_container_part">

    <div class="row">
            <div class="form-group float-left">
                <label for="description[]">Description:</label>
                <textarea rows="3" class="form-control  rounded-0" style="width:300px;" name="description[]"></textarea>
            </div>
            <div class="form-group float-left">
                <label for="amount[]">Rupees</label>
                <input type="text" class="form-control nowyouseeme amount" name="amount[]"/>
            </div>
    </div>
</div>

<div class="row oop" style="display:none;">
            <div class="form-group float-left">
                <input type="text" class="form-control" name="pocket" value="Out of Pocket" readonly/>
            </div>
            <div class="form-group float-left">
                <input type="text" class="form-control oopamount" name="amountoop" value="0"/>
            </div>
</div>

<div class="row st" style="display:none;">
            <div class="form-group float-left">
                <input type="text" class="form-control" name="salestax" value="Sindh Sales Tax @8%" readonly/>
            </div>
            <div class="form-group float-left">
                <input type="text" class="form-control stamount" name="amountst" value="0"/>
            </div>
</div>

<div class="row total" style="display:none;">
            <div class="form-group float-left">
                <input type="text" class="form-control" name="total" value="Total" readonly/>
            </div>
            <div class="form-group float-left">
                <input type="text" class="form-control grandtotal" name="amounttotal" readonly/>
            </div>
</div>

<div class="row">
        <div class="float-right">
                <button class="btn btn-sm btn-primary add_more_button">Add More Fields</button>
                <button type="submit" class="btn btn-primary prevent-multi-submit">Enter Invoice</button>
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


var x = 1;

html = '<div class="row">';
html+= '<div class="form-group float-left"><textarea rows="2" class="form-control  rounded-0" name="description[]"></textarea></div>';
html+= '<div class="form-group float-left"><input type="text" class="form-control nowyouseeme amount" name="amount[]" value="0"/></div>';
html+= '<div class="form-group float-left"><a href="#" class="remove_field" style="margin-left:10px;">Remove</a></div></div>';

$(document).on("focus",".nowyouseeme", function(){
    $('.oop').fadeIn('medium');
    $('.st').fadeIn('medium');
    $('.total').fadeIn('medium');
	});


$(document).on("change",".amount", function(){

        var sum = 0;
        $('.amount').each(function(){
            sum += parseFloat($(this).val());
        });

        var oop = parseFloat($('.oop').find('.oopamount').val());
        if(oop>0)
        sum+=oop;

        var stax= (sum*0.08);
        $('.st').find('.stamount').val(stax);

        sum+=stax;

        $('.grandtotal').val(sum);
	});

$(document).on("change",".oopamount", function(){

        var sum = 0;
        $('.amount').each(function(){
            sum += parseFloat($(this).val());
        });

        var oop = parseFloat($('.oop').find('.oopamount').val());
        if(oop>0)
        sum+=oop;

        var stax= (sum*0.08);
        $('.st').find('.stamount').val(stax);

        sum+=stax;

        $('.grandtotal').val(sum);
	});

$(document).on("change",".stamount", function(){

        var sum = 0;
        $('.amount').each(function(){
            sum += parseFloat($(this).val());
        });

        var oop = parseFloat($('.oop').find('.oopamount').val());
        if(oop>0)
        sum+=oop;

        var stax= parseFloat($('.st').find('.stamount').val());
        if(stax>0)
        sum+=stax;

        $('.grandtotal').val(sum);
	});

$('.add_more_button').click(function(e){
    e.preventDefault();
    x++;
    $('.input_fields_container_part').append(html);
    });

$('.input_fields_container_part').on("click",".remove_field", function(e){
    e.preventDefault(); $(this).parent('div').parent('div').remove();
    x--;

        var sum = 0;
        $('.amount').each(function(){
            sum += parseFloat($(this).val());
        });

        var oop = parseFloat($('.oop').find('.oopamount').val());
        if(oop>0)
        sum+=oop;

        var stax= parseFloat($('.st').find('.stamount').val());
        if(stax>0)
        sum+=stax;

        $('.grandtotal').val(sum);

    })

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

    $('.prevent-multi').on('submit', function(){
        $('.prevent-multi-submit').attr('disabled','true');
        return true;
    });

});


</script>


@endsection
