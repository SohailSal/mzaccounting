<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ledger </title>

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

            $prebal = 0;
            $lastbalance = 0;
            $ite = 0;
            $debits = 0;
            $credits = 0;

            if ($previous->count()) { 
                foreach ($previous as $value) {
                $prebal= $lastbalance + floatval($value['debit']) - floatval($value['credit']);
                $lastbalance = $prebal;
                $ite++;
                }
            }

            $balance = [];
            $ite = 0;
            foreach ($entries as $value) {
               $balance[$ite]= $lastbalance + floatval($value['debit']) - floatval($value['credit']);
                $lastbalance = $balance[$ite];
               $ite++;
            }

            $dt = \Carbon\Carbon::now(new DateTimeZone('Asia/Karachi'))->format('M d, Y - h:m a');
    ?>


<div class="information">
    <table width="100%">
        <tr>
            <td align="left" style="width: 40%;">
                <h3>{{$acc->head_of_account}}</h3>
            </td>
            <td align="center">
            </td>
            <td align="right" style="width: 40%;">
                <h5>{{$period}}<br>
                    Generated on: {{ $dt}}
                </h5>
            </td>
        </tr>
    </table>
</div>


<div class="information">
    <table width="100%" style="border-collapse: collapse;">
            <thead>
        <tr>
            <th style="width: 15%;border-bottom:2pt solid black;">
                <strong>Ref</strong>
            </th>
            <th style="width: 15`%;border-bottom:2pt solid black;">
                <strong>Date</strong>
            </th>
            <th style="width: 40%;border-bottom:2pt solid black;">
                <strong>Description</strong>

            </th>
            <th style="width: 10%;border-bottom:2pt solid black;" align="right">
                <strong>Debit</strong>

            </th>
            <th style="width: 10%;border-bottom:2pt solid black;" align="right">
                <strong>Credit</strong>

            </th>
            <th style="width: 10%;border-bottom:2pt solid black;" align="right">
                <strong>Balance</strong>

            </th>
        </tr>
            </thead>
            <tbody>

        <tr>
            <td style="width: 15%;">
            </td>
            <td style="width: 15%;">
            </td>
            <td style="width: 40%; border-right: 1pt solid black;">
                <strong>Opening Balance</strong>
            </td>
            <td style="width: 10%; border-right: 1pt solid black;" align="right">
            </td>
            <td style="width: 10%; border-right: 1pt solid black;" align="right">
            </td>
            <td style="width: 10%" align="right">
            <strong> {{str_replace(['Rs.','.00'],'',$fmt->formatCurrency($prebal,'Rs.'))}} </strong>
            </td>
        </tr>


        @foreach ($entries as $entry)

    <?php
            $trans_date = \Carbon\Carbon::parse($entry['date_of_transaction'])->format('d-m-Y');
    ?>
        <tr>
            <td style="width: 15%;">
                {{$entry['ref']}}
            </td>
            <td style="width: 15%;">
                {{$trans_date}}
            </td>
            <td style="width: 40%; border-right: 1pt solid black;">
                {{$entry['description']}}

            </td>
            <td style="width: 10%; border-right: 1pt solid black;" align="right">
                {{str_replace(['Rs.','.00'],'',$fmt->formatCurrency($entry['debit'],'Rs.'))}}

            </td>
            <td style="width: 10%; border-right: 1pt solid black;" align="right">
                {{str_replace(['Rs.','.00'],'',$fmt->formatCurrency($entry['credit'],'Rs.'))}}

            </td>
            <td style="width: 10%" align="right">
                {{str_replace(['Rs.','.00'],'',$fmt->formatCurrency($balance[$loop->index],'Rs.'))}}

            </td>
        </tr>

        <?php
                $debits = $debits + $entry['debit'];
                $credits = $credits + $entry['credit'];
        ?>

        @endforeach

        <tr>
            <td style="width: 15%;border-top:1pt solid black;">
            </td>
            <td style="width: 15%;border-top:1pt solid black;">
            </td>
            <td style="width: 40%; border-right: 1pt solid black;border-top:1pt solid black;">
            </td>
            <td style="width: 10%; border-right: 1pt solid black;border-top:1pt solid black;border-bottom:3pt double black;" align="right">
                <strong>{{str_replace(['Rs.','.00'],'',$fmt->formatCurrency($debits,'Rs.'))}}</strong>

            </td>
            <td style="width: 10%; border-right: 1pt solid black;border-top:1pt solid black;border-bottom:3pt double black;" align="right">
                <strong>{{str_replace(['Rs.','.00'],'',$fmt->formatCurrency($credits,'Rs.'))}}</strong>

            </td>
            <td style="width: 10%; border-top:1pt solid black;" align="right">
            </td>
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
