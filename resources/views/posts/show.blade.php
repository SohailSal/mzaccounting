@extends('base')
@section('main')
<div class="row">
    <div class="col-sm-12">
    <h1 class="display-5">Unposted Payment</h1>
        <div>
        <a style="margin: 19px;" class="btn btn-primary" href="{{ route('posts.index') }}"> Back</a>
        <a style="margin: 19px;" class="btn btn-primary" href="{{ route('posts.create')}}">New Payment</a>
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
            {{ $post->ref }}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Date of transaction:</strong>
            {{ $post->date_of_payment }}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Head of Account:</strong>
            {{ $post->account->head_of_account }}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Description:</strong>
            {{ $post->description }}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Cheque #:</strong>
            {{ $post->cheque }}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Payee:</strong>
            {{ $post->payee }}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Amount:</strong>
            {{ str_replace(['Rs.','.00'],'',$fmt->formatCurrency($post->amount,'Rs.')) }}
        </div>
    </div>
</div>
@endsection

