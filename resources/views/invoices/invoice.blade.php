<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice - {{$invoice->ref}}</title>

    <style type="text/css">
        @page {margin: 20px;}
        body {margin: 40px;}
        * {font-family: Verdana, Arial, sans-serif;}
        a {text-decoration: none;}
        table {font-size: medium;}
        tfoot tr td {font-weight: bold;font-size: medium;}
        .invoice table {margin: 15px;}
        .invoice h3 {margin-left: 15px;}
        .information {background-color: #fff;}
        .information .logo {margin: 5px;}
        .information table {padding: 10px;}
    </style>
</head>
<body>
    <?php
            $fmt = new NumberFormatter( 'en_GB', NumberFormatter::CURRENCY );
            $amt = new NumberFormatter( 'en_GB', NumberFormatter::SPELLOUT );
            $fmt->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 0);
            $fmt->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '');
    ?>
<br>
<br>
<br>
<br>
<br>
<div class="information">
    <table width="100%">
        <tr>
            <td align="left" style="width: 40%;">
                <h4>Ref: {{$invoice->ref}}</h4>
            </td>
            <td align="center">
            </td>
            <td align="right" style="width: 40%;">
            </td>
        </tr>

        <tr>
            <td align="left" style="width: 40%;">
<h4>{{ \Carbon\Carbon::parse($invoice->date_of_invoice)->format('F d, Y')}}</h4>
            </td>
            <td align="center">
            </td>
            <td align="right" style="width: 40%;">
            </td>
        </tr>
        <tr>
            <td align="left" style="width: 60%;">
                <h4>{{$invoice->account->head_of_account}}
                <br>{!! nl2br(e($invoice->account->client->address)) !!}</h4>

            </td>
            <td align="center">
            </td>
            <td align="right" style="width: 40%;">
            </td>
        </tr>
    </table>
</div>
<br/>
<div class="invoice">
    <p style="margin:18px;">Dear Sir(s),</p>
    <pre>
    We append a memo of our charges for professional services rendered. We shall be glad
    to receive an early remittance.

                                                                                                                    Very truly yours,
    </pre>
    <br>
    <br>
    <br>
    <table width="100%" style="border-collapse: collapse;">
        <thead>
        <tr>
            <th style="border-top: 2px solid; border-right: 2px solid;" width="80%"></th>
            <th style="margin:10px;padding:10px;border-top: 2px solid;" width="20%" align='right'>Rupees</th>
        </tr>
        </thead>
        <tbody>
    @foreach($invoice->invoiceEntries as $entry)
        <tr>
            @if($loop->last)
            <td style=" border-right: 2px solid;"><strong>{{$entry->description}}</strong></td>
            @else
            <td style=" border-right: 2px solid;">{{$entry->description}}</td>
            @endif
            @if($loop->last)
            <td style=" margin:10px;padding:10px;border-top: 2px solid ; border-bottom: 5px double;" align="right"><strong>{{ str_replace(['Rs.','.00'],'',$fmt->formatCurrency($entry->amount,'Rs.')) }}</strong></td>
            @else
            <td style="margin:10px;padding:10px;" align="right">{{ str_replace(['Rs.','.00'],'',$fmt->formatCurrency($entry->amount,'Rs.')) }}</td>
            @endif
        </tr>
    @endforeach
        </tbody>
   </table>
    <div style="margin:18px;">
        @foreach($invoice->invoiceEntries as $entry)
                @if($loop->last)
                <strong>Rupees {{$amt->format($entry->amount) }} only.</strong></td>
                @endif
        @endforeach
    <br>
    <br>
    <pre><strong>N.T.N    1691426-7</strong></pre>
    </div>
</div>

</body>
</html>
