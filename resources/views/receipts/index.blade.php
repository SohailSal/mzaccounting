@extends('base')
@section('main')
<div class="row">
<div class="col-sm-12">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div>
  @endif
    <h1 class="display-5">Receipts</h1>
    <div>
    <a style="margin: 5px;" href="{{ route('home')}}" class="btn btn-primary">Home</a>
    <a style="margin: 5px;" href="{{ route('receipts.create')}}" class="btn btn-primary">New Receipt</a>
    <!-- <a href="{{action('ReceiptController@getReceipts',  ['id'=>'25', 'actual'=> '26'])}}" class="btn btn-primary">Receipts PDF</a> -->
    <form method="get" action="{{ route('receipts.index') }}">
      @csrf
      <div class="float-right btn-group">
        <input type="text" class="form-control" name="search" value="{{$search}}"/>
        <button class="btn btn-sm btn-primary search">Search</button>
      </div>
    </form>
    </div>

       <?php
            $fmt = new NumberFormatter( 'en_GB', NumberFormatter::CURRENCY );
            $fmt->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 0);
            $fmt->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '');
    ?>
    <div>
    {{$receipts->links()}}
</div>
  <table class="table table-striped">
    <thead>
        <tr>
          <td>Ref</td>
          <td>Date of Receipt</td>
          <td>Client</td>
          <td align='right'>Amount</td>
          <td align='right'>Income Tax withheld</td>
          <td align='right'>Sales Tax withheld</td>
          <td colspan = 2 style="text-align:center;">Actions</td>
        </tr>
    </thead>
    <tbody>
        @foreach($receipts as $receipt)
        <tr>
            <td>{{$receipt->ref}}</td>
            <td>{{$receipt->date_of_receipt}}</td>
            <td>{{$receipt->account->head_of_account}}</td>
            <td align='right'>{{str_replace(['Rs.','.00'],'',$fmt->formatCurrency($receipt->amount,'Rs.'))}}</td>
            <td align='right'>{{str_replace(['Rs.','.00'],'',$fmt->formatCurrency($receipt->itax,'Rs.'))}}</td>
            <td align='right'>{{str_replace(['Rs.','.00'],'',$fmt->formatCurrency($receipt->stax,'Rs.'))}}</td>
            <td>
                <a href="{{ route('receipts.edit',$receipt->id)}}" class="btn btn-primary">Edit</a>
            </td>
            <td>
                <a href="{{ route('receipts.show',$receipt->id)}}" class="btn btn-info">Show</a>
          	</td>
        </tr>
        @endforeach
    </tbody>
  </table>
<div>
</div>
<div>
    {{$receipts->links()}}
</div>
@endsection
