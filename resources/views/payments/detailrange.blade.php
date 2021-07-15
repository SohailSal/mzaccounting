<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payments</title>

    <style type="text/css">
        @page {margin-right: 10px;margin-left:45px; margin-top:-10px;}
        body {margin: 10px;}
        * {font-family: Verdana, Arial, sans-serif;}
        a {text-decoration: none;}
        table {font-size: x-small;}
        tfoot tr td {font-weight: bold;font-size: medium;}
        .invoice table {margin: 5px;}
        .invoice h3 {margin-left: 5px;}
        .information {background-color: #fff;}
        .information .logo {margin: 5px;}
        .information table {padding: 5px;}
        tr:nth-child(even) {background-color: #f2f2f2;}
    </style>
</head>
<body>
    <?php
            $fmt = new NumberFormatter( 'en_GB', NumberFormatter::CURRENCY );
            $amt = new NumberFormatter( 'en_GB', NumberFormatter::SPELLOUT );
            $fmt->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 0);
            $fmt->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '');


            $dt = \Carbon\Carbon::now(new DateTimeZone('Asia/Karachi'))->format('M d, Y - h:m a');

            $total = 0;
    ?>

<div class="information">
    <table width="100%" style="border-collapse: collapse;">
            <thead>
                <tr>
                    <th colspan = 3 align="left">
                        <h3>Payments</h3>
                    </th>
                    <th colspan = 3 align="right">
                <h5>{{$period}}<br>
                Generated on: {{$dt}}
                </h5>
                    </th>
                </tr>
        <tr>
            <th style="width: 10%;border:1pt solid black;">
                <strong>Ref</strong>
            </th>
            <th style="width: 8%;border:1pt solid black;">
                <strong>Date</strong>
            </th>
            <th style="width: 15%;border:1pt solid black;" align="centre">
               <strong>Account</strong>
            </th>
            <th style="width: 33%;border:1pt solid black;" align="centre">
               <strong>Description</strong>
            </th>
            <th style="width: 20%;border:1pt solid black;" align="centre">
                <strong>Payee</strong>
            </th>
            <th style="width: 7%;border:1pt solid black;" align="centre">
                <strong>Cheque #</strong>
            </th>
            <th style="width: 7%;border:1pt solid black;" align="centre">
                <strong>Amount</strong>
            </th>
        </tr>
            </thead>
            <tbody>
        @foreach ($payments as $item)
    <?php
            $trans_date = \Carbon\Carbon::parse($item['date_of_payment'])->format('d-m-Y');
    ?>

        <tr>
            <td style="border-right: 1pt solid black; border-left: 1pt solid black;">
                {{$item['ref']}}
            </td>
            <td style="border-right: 1pt solid black;">
                {{$trans_date}}
            </td>
            <td style="border-right: 1pt solid black;">
                {{$item['head_of_account']}}
            </td>
            <td style="border-right: 1pt solid black;">
                {{$item['description']}}
            </td>
            <td style="border-right: 1pt solid black;">
                {{$item['payee']}}
            </td>
            <td style="border-right: 1pt solid black;" align="centre">
                {{$item['cheque']}}
            </td>
            <td style="border-right: 1pt solid black;" align="right">
                {{str_replace(['Rs.','.00'],'',$fmt->formatCurrency($item['amount'],'Rs.'))}}
            </td>
        </tr>
        <?php
                $total = $total + $item['amount'];
        ?>
        @endforeach
        <tr>
            <td style="border-top: 1pt solid black;"></td>
            <td style="border-top: 1pt solid black;"></td>
            <td style="border-top: 1pt solid black;"></td>
            <td style="border-top: 1pt solid black;"></td>
            <td style="border-top: 1pt solid black;"></td>
            <td style="border-top: 1pt solid black;"></td>
            <td style="border-top: 1pt solid black; border-bottom: 3pt double black;" align="right"><strong>{{str_replace(['Rs.','.00'],'',$fmt->formatCurrency($total,'Rs.'))}}</strong></td>
        </tr>
            </tbody>

    </table>
</div>
<br/>
<script type="text/php">
    if (isset($pdf)) {
        $x = 770;
        $y = 580;
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
