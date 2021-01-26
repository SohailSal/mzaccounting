<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Voucher - {{$payment->ref}}</title>

    <style type="text/css">
        @page {margin: 20px;}
        body {margin: 40px;}
        * {font-family: Verdana, Arial, sans-serif;}
        a {text-decoration: none;}
        table {font-size: medium; margin: 15px;}
        .pv table {margin: 15px; border: 2px solid;}
        .pv td {margin:10px;padding:10px; border-bottom: 2px solid;}
        .information {background-color: #fff;}
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

<div class="information">
                <h1 align="center">Payment Voucher</h1>
    <table width="100%">
        <tr>
            <td align="left" >
                Reference: <strong>{{$payment->ref}}</strong>
            </td>
            <td align="center">
            </td>
            <td align="right">
                Dated: <strong>{{ \Carbon\Carbon::parse($payment->date_of_payment)->format('F d, Y')}}</strong>
            </td>
        </tr>
    </table>
</div>

<div class="pv">
    <table width="100%" style="border-collapse: collapse;">
        <tbody>
        <tr>
            <td style="width: 23%">Amount:</td>
            <td style="width: 77%"><strong>Rs. {{ str_replace(['Rs.','.00'],'',$fmt->formatCurrency($payment->amount,'Rs.')) }}</strong></td>
        </tr>
        <tr>
            <td>In words:</td>
            <td><strong>Rupees {{$amt->format($payment->amount) }} only.</strong></td>
        </tr>
        <tr>
            <td>On account of:</td>
            <td><strong>{{$payment->account->head_of_account}}</strong></td>
        </tr>
        <tr>
            <td>Description:</td>
            <td><strong>{{$payment->description}}</strong></td>
        </tr>
        <tr>
            <td>Cheque #:</td>
            <td><strong>{{$payment->cheque}}</strong></td>
        </tr>
        <tr>
            <td>Payee:</td>
            <td><strong>{{$payment->payee}}</strong></td>
        </tr>
        </tbody>
   </table>
 </div>
 <br>
 <br>
 <br>
 <br>
 <br>
<div>
<table width="100%">
    <tr>
        <td style="border-bottom: 2px solid; width: 20%"></td>
        <td style="width: 20%"></td>
        <td style="border-bottom: 2px solid; width: 20%"></td>
        <td style="width: 20%"></td>
        <td style="border-bottom: 2px solid; width: 20%"></td>
    </tr>
    <tr>
        <td align="centre">Prepared by</td>
        <td></td>
        <td align="centre">Approved by</td>
        <td></td>
        <td align="centre">Received by</td>
    </tr>
</table>
</div>
</body>
</html>
