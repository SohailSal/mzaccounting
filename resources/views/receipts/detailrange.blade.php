<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipts</title>

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

            $totalr = 0;
            $totalt = 0;
            $totals = 0;
    ?>

<div class="information">
    <table width="100%" style="border-collapse: collapse;">
            <thead>
                <tr>
                    <th colspan = 3 align="left">
                        <h3>Receipts</h3>
                    </th>
                    <th colspan = 3 align="right">
                <h5>{{$period}}<br>
                Generated on: {{$dt}}
                </h5>
                    </th>
                </tr>
        <tr>
            <th style="width: 15%;border:1pt solid black;">
                <strong>Ref</strong>
            </th>
            <th style="width: 10%;border:1pt solid black;">
                <strong>Date</strong>
            </th>
            <th style="width: 40%;border:1pt solid black;" align="centre">
               <strong>Client</strong>
            </th>
            <th style="width: 15%;border:1pt solid black;" align="centre">
               <strong>Cheque Amount</strong>
            </th>
            <th style="width: 10%;border:1pt solid black;" align="centre">
                <strong>Income tax deducted</strong>
            </th>
            <th style="width: 10%;border:1pt solid black;" align="centre">
                <strong>Sales tax deducted</strong>
            </th>
        </tr>
            </thead>
            <tbody>
        @foreach ($receipts as $item)

    <?php
            $trans_date = \Carbon\Carbon::parse($item['date_of_receipt'])->format('d-m-Y');
    ?>

        <tr>
            <td style="width: 15%; border-right: 1pt solid black; border-left: 1pt solid black;">
                {{$item['ref']}}
            </td>
            <td style="width: 10%; border-right: 1pt solid black;">
                {{$trans_date}}
            </td>
            <td style="width: 40%; border-right: 1pt solid black;">
                {{$item['head_of_account']}}
            </td>
            <td style="width: 15%; border-right: 1pt solid black;" align="right">
                {{str_replace(['Rs.','.00'],'',$fmt->formatCurrency($item['amount'],'Rs.'))}}
            </td>
            <td style="width: 10%; border-right: 1pt solid black;" align="right">
                {{str_replace(['Rs.','.00'],'',$fmt->formatCurrency($item['itax'],'Rs.'))}}
            </td>
            <td style="width: 10%; border-right: 1pt solid black;" align="right">
                {{str_replace(['Rs.','.00'],'',$fmt->formatCurrency($item['stax'],'Rs.'))}}
            </td>
        </tr>
        <?php
                $totalr = $totalr + $item['amount'];
                $totalt = $totalt + $item['itax'];
                $totals = $totals + $item['stax'];
        ?>
        @endforeach
        <tr>
            <td style="border-top: 1pt solid black;"></td>
            <td style="border-top: 1pt solid black;"></td>
            <td style="border-top: 1pt solid black;"></td>
            <td style="border-top: 1pt solid black; border-bottom: 3pt double black;" align="right"><strong>{{str_replace(['Rs.','.00'],'',$fmt->formatCurrency($totalr,'Rs.'))}}</strong></td>
            <td style="border-top: 1pt solid black; border-bottom: 3pt double black;" align="right"><strong>{{str_replace(['Rs.','.00'],'',$fmt->formatCurrency($totalt,'Rs.'))}}</strong></td>
            <td style="border-top: 1pt solid black; border-bottom: 3pt double black;" align="right"><strong>{{str_replace(['Rs.','.00'],'',$fmt->formatCurrency($totals,'Rs.'))}}</strong></td>
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
