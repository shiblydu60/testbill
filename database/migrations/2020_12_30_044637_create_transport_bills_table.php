<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transport_bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->dateTime('bill_date', $precision = 0);
            $table->double('amount', 12, 2);
            $table->string('source');
            $table->string('destination');
            $table->string('file_location')->nullable();
            $table->integer('project_id')->nullable();
            $table->text('comment')->nullable();
            $table->string('monitored_by')->nullable();
            $table->integer('status')->nullable();
            $table->text('note')->nullable();
            $table->dateTime('monitored_at', $precision = 0)->nullable();
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
        Schema::dropIfExists('transport_bills');
    }
}
