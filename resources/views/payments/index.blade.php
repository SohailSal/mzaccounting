@extends('base')
@section('main')
<div class="row">
<div class="col-sm-12">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div>
  @endif
    <h1 class="display-5">Payments</h1>
    <div>
    <a style="margin: 5px;" href="{{ route('home')}}" class="btn btn-primary">Home</a>
    <a style="margin: 5px;" href="{{ route('posts.create')}}" class="btn btn-primary">New Payment</a>
    <!-- <a href="{{action('PaymentController@getPayments',  ['id'=>'25', 'actual'=> '26'])}}" class="btn btn-primary">Payments PDF</a> -->
    </div>
       <?php
            $fmt = new NumberFormatter( 'en_GB', NumberFormatter::CURRENCY );
            $fmt->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 0);
            $fmt->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '');
    ?>
    <div>
    {{$payments->links()}}
</div>
  <table class="table table-striped">
    <thead>
        <tr>
          <td>Ref</td>
          <td>Date of Payment</td>
          <td>Head of Account</td>
          <td>Payee</td>
          <td align='right'>Amount</td>
          <td colspan = 3 style="text-align:center;">Actions</td>
        </tr>
    </thead>
    <tbody>
        @foreach($payments as $payment)
        <tr>
            <td>{{$payment->ref}}</td>
            <td>{{$payment->date_of_payment}}</td>
            <td>{{$payment->account->head_of_account}}</td>
            <td>{{$payment->payee}}</td>
            <td align='right'>{{str_replace(['Rs.','.00'],'',$fmt->formatCurrency($payment->amount,'Rs.'))}}</td>
            <td>
                <a href="{{ route('payments.edit',$payment->id)}}" class="btn btn-primary">Edit</a>
            </td>
            <td>
                <a href="{{ route('payments.show',$payment->id)}}" class="btn btn-info">Show</a>
          	</td>
            <td>
                <a href="{{action('PaymentController@getPV', $payment->id)}}">Generate PV</a>
            </td>

        </tr>
        @endforeach
    </tbody>
  </table>
<div>
</div>
<div>
    {{$payments->links()}}
</div>
@endsection
