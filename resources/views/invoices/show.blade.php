@extends('base')
@section('main')
<div class="row">
    <div class="col-sm-12">
    @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div>
  @endif

    <h1 class="display-5">Invoice</h1>
        <div>
        <a style="margin: 19px;" class="btn btn-primary" href="{{ route('invoices.index') }}"> Back</a>
        <a style="margin: 19px;" class="btn btn-primary" href="{{ route('invoices.create')}}">New Invoice</a>
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
            {{ $invoice->ref }}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Date of invoice:</strong>
            {{ $invoice->date_of_invoice }}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Client:</strong>
            {{ $invoice->account->head_of_account }}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Paid:</strong>
            @if($invoice->paid =='0')
            No
            @else
            Yes
            @endif
        <form method="post" action="{{ route('invoices.update', $invoice->id) }}">
            @method('PATCH')
            @csrf
            <button class="btn btn-primary" onclick="return confirm('Are you sure?')" type="submit">Change status</button>
        </form>
        </div>
    </div>
     <div class="col-sm-12">
        <div class="form-group">
        <table style="width: auto;" class="table table-striped table-condensed">
            <thead>
                <tr>
                <th style="width: 70%; border-bottom: 1pt solid black;"><strong>Description</strong></th>
                <th style="width: 30%; border-bottom: 1pt solid black;"><strong>Amount</strong></th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->invoiceentries as $entry)
                <tr>
                    <td style="width: 70%; border-right: 1pt solid black;">{{$entry->description}}</td>
                    @if($loop->last)
                    <td style=" margin:10px;padding:10px;border-top: 2px solid ; border-bottom: 5px double;" align="right"><strong>{{ str_replace(['Rs.','.00'],'',$fmt->formatCurrency($entry->amount,'Rs.')) }}</strong></td>
                    @else
                    <td style="width: 30%;" align="right">{{str_replace(['Rs.','.00'],'',$fmt->formatCurrency($entry->amount,'Rs.'))}}</td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>


</div>
@endsection

