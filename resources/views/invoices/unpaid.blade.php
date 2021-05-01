<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Unpaid Invoices</title>

    <style type="text/css">
        @page {margin: 20px;}
        body {margin: 10px;}
        * {font-family: Verdana, Arial, sans-serif;}
        a {text-decoration: none;}
        table {font-size: x-small;}
        tfoot tr td {font-weight: bold;font-size: medium;}
        .invoice table {margin: 15px;}
        .invoice h3 {margin-left: 15px;}
        .information {background-color: #fff;}
        .information .logo {margin: 5px;}
        .information table {padding: 10px;}
        tr:nth-child(even) {background-color: #f2f2f2;}
    </style>
</head>
<body>
    <?php
            $fmt = new NumberFormatter( 'en_GB', NumberFormatter::CURRENCY );
            $amt = new NumberFormatter( 'en_GB', NumberFormatter::SPELLOUT );
            $fmt->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 0);
            $fmt->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '');

        $invoices = App\Invoice::where('paid','=','0')->get();
//$invoices = DB::table('invoices')->where('paid','=','0')->get();
            $dt = \Carbon\Carbon::now(new DateTimeZone('Asia/Karachi'))->format('M d, Y - h:m a');

            $total = 0;
    ?>


<div class="information">
    <table width="100%">
        <tr>
            <td align="left" style="width: 40%;">
    <h3>Unpaid Invoices</h3>

            </td>
            <td align="center">
            </td>
            <td align="right" style="width: 40%;">
                <h5>Generated on: {{ $dt}}</h5>
                <h4></h4>
            </td>
        </tr>
    </table>
</div>


<div class="information">
    <table width="100%" style="border-collapse: collapse;">
            <thead>
        <tr>
            <th style="width: 20%;border:1pt solid black;">
                <strong>Ref</strong>
            </th>
            <th style="width: 15%;border:1pt solid black;">
                <strong>Date</strong>
            </th>
            <th style="width: 20%;border:1pt solid black;" align="centre">
               <strong>Income Type</strong>
            </th>
            <th style="width: 35%;border:1pt solid black;" align="centre">
               <strong>Client</strong>
            </th>
            <th style="width: 10%;border:1pt solid black;" align="centre">
                <strong>Amount</strong>

        </tr>
            </thead>
            <tbody>
        @foreach ($invoices as $item)

        <tr>
            <td style="width: 20%; border-right: 1pt solid black; border-left: 1pt solid black;">
                {{$item->ref}}
            </td>
            <td style="width: 15%; border-right: 1pt solid black;">
                {{$item->date_of_invoice}}
            </td>

      <?php
                $tran = App\Transaction::where('ref',$item->ref)->first();
                $entries = App\Entry::where('transaction_id',$tran->id)->get();
                $acc = '';
                foreach ($entries as $ite) {
                    if (strpos($ite->account->head_of_account, 'Income') !== false)
                    {$acc = $ite->account->head_of_account;}
                }

     ?>


            <td style="width: 20%; border-right: 1pt solid black;">
                {{$acc}}
            </td>
            <td style="width: 35%; border-right: 1pt solid black;">
                {{$item->account->head_of_account}}
            </td>

      <?php
            if(App\InvoiceEntry::where([['invoice_id',$item->id],['description','Total']])->first()){
                $inv = App\InvoiceEntry::where([['invoice_id',$item->id],['description','Total']])->first();
                $total = $total + $inv->amount;
            }
    ?>

            @if(App\InvoiceEntry::where([['invoice_id',$item->id],['description','Total']])->first())
            <td style="width: 10%; border-right: 1pt solid black;" align="right">
                {{str_replace(['Rs.','.00'],'',$fmt->formatCurrency($inv->amount,'Rs.'))}}
            </td>
            @endif
        </tr>
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="width: 10%; border-top: 1pt solid black; border-bottom: 3pt double black;" align="right"><strong>{{str_replace(['Rs.','.00'],'',$fmt->formatCurrency($total,'Rs.'))}}</strong></td>
        </tr>
            </tbody>

    </table>
</div>
<br/>
<script type="text/php">
    if (isset($pdf)) {
        $x = 500;
        $y = 800;
        $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
        $font = null;
        $size = 10;
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $word_space, $char_space, $angle);
    }
</script>
</body>
</html>
