<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
<div class="row">
    <div class="col-sm-12">
    <h1 class="display-5">Type of Client</h1>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <strong>ID:</strong>
            {{ $clienttype->id }}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Type of Client:</strong>
            {{ $clienttype->type_of_client }}
        </div>
    </div>

    <?php   $foo = -134500;
            $fmt = new NumberFormatter( 'en_GB', NumberFormatter::CURRENCY );
            $amt = new NumberFormatter( 'en_GB', NumberFormatter::SPELLOUT );
    ?>

    <div class="col-sm-12">
        <div class="form-group">
            <strong>Currency:</strong>
            {{ $fmt->formatCurrency($foo, "") }}
            <br>
            {{ $fmt->formatCurrency($foo, "Rs.") }}
            <br>
    <?php   $fmt->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 0);
            $fmt->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '');
    ?>
            {{ $fmt->formatCurrency($foo,'Rs.') }}
            <br>
            {{$amt->format($foo)}}
        </div>
    </div>
</div>
  </body>
  </html>
