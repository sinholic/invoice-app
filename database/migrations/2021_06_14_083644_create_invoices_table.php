<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->date('issue_date')->nullable()->default(\DB::raw('NCURRENT_TIMESTAMP'));
            $table->date('due_date')->nullable()->default(\DB::raw('NCURRENT_TIMESTAMP'));
            $table->text('subject');
            $table->boolean('is_paid')->nullable()->default(false);
            $table->unsignedBigInteger('client_id');
            $table->timestamps();
            // Define the relationship between table below here
            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
