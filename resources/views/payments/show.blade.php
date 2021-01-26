@extends('base')
@section('main')
<div class="row">
    <div class="col-sm-12">
    <h1 class="display-5">Payment</h1>
        <div>
        <a style="margin: 19px;" class="btn btn-primary" href="{{ route('payments.index') }}"> Back</a>
        <a style="margin: 19px;" class="btn btn-primary" href="{{ route('payments.create')}}">New Payment</a>
        </div>
    </div>
</div>

    <?php
            $fmt = new NumberFormatter( 'en_GB', NumberFormatter::CURRENCY );
            $fmt->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 0);
            $fmt->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '');
    ?>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Ref:</strong>
            {{ $payment->ref }}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Date of transaction:</strong>
            {{ $payment->date_of_payment }}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Head of Account:</strong>
            {{ $payment->account->head_of_account }}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Description:</strong>
            {{ $payment->description }}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Cheque #:</strong>
            {{ $payment->cheque }}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Payee:</strong>
            {{ $payment->payee }}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Amount:</strong>
            {{ str_replace(['Rs.','.00'],'',$fmt->formatCurrency($payment->amount,'Rs.')) }}
        </div>
    </div>
</div>
@endsection

