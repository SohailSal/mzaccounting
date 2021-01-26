<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('ref');
            $table->date('date_of_payment');
            $table->integer('account_id')->unsigned();
            $table->string('description');
            $table->string('mode');
            $table->string('cheque')->nullable();
            $table->string('payee')->nullable();
            $table->decimal('amount', 14, 2);
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->tinyInteger('posted')->default('0');
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
        Schema::dropIfExists('posts');
    }
}
