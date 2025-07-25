<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->unsignedBigInteger('dealer_id');
            //$table->integer('dealer_id');
            $table->integer('user_id')->nullable();
            $table->integer('sl_no');
            $table->string('brand');
            $table->string('part_id');
            $table->text('description');
            $table->decimal('qty', 10, 2);
            $table->decimal('rate', 10, 2);
            $table->decimal('amount', 10, 2);
            $table->timestamps();

            $table->foreign('dealer_id')->references('id')->on('dealers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['dealer_id']);
        });

        Schema::dropIfExists('invoices');
    }
};
