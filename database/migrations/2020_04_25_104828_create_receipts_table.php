<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->string('ref');
            $table->date('date_of_receipt');
            $table->integer('invoice_id')->unsigned();
            $table->integer('account_id')->unsigned();
            $table->string('description');
            $table->decimal('amount', 14, 2);
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipts');
    }
}
