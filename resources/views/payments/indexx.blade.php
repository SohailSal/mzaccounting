@extends('base')
@section('main')
<div class="row">
<div class="col-sm-12">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div>
  @endif
    <h1 class="display-5">Delete Payments</h1>
    <div>
    <a style="margin: 5px;" href="{{ route('home')}}" class="btn btn-primary">Home</a>
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
          <td style="text-align:center;">Actions</td>
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
            <!-- <td>
                <a href="{{ route('payments.show',$payment->id)}}" class="btn btn-info">Show</a>
          	</td> -->
            <td>
                <form action="{{ route('payments.destroy', $payment->id)}}" method="post">
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
    {{$payments->links()}}
</div>
@endsection
