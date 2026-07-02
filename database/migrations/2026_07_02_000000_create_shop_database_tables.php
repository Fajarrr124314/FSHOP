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
        // Services catalog table
        Schema::create('services', function (Blueprint $table) {
            $table->string('id')->primary(); // unique slug (e.g. web-dev)
            $table->string('category'); // web, mobile, design, tugas
            $table->string('title');
            $table->string('image');
            $table->text('short_desc');
            $table->string('price');
            $table->text('tags'); // JSON array of tags
            $table->text('features'); // JSON array of features
            $table->timestamps();
        });

        // Games catalog table
        Schema::create('games', function (Blueprint $table) {
            $table->string('id')->primary(); // unique slug (e.g. mlbb)
            $table->string('category'); // mobile, pc, ppob
            $table->string('title');
            $table->string('publisher');
            $table->string('image');
            $table->string('badge')->nullable();
            $table->boolean('has_zone')->default(false);
            $table->string('zone_placeholder')->nullable();
            $table->timestamps();
        });

        // Game/PPOB nominal packages table
        Schema::create('game_packages', function (Blueprint $table) {
            $table->string('id')->primary(); // unique package ID (e.g. ml-wdp)
            $table->string('game_id');
            $table->string('name');
            $table->string('price');
            $table->string('original')->nullable();
            $table->timestamps();

            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
        });

        // Customer orders table
        Schema::create('orders', function (Blueprint $table) {
            $table->string('id')->primary(); // FSHOP-YYYYMMDD-XXXX
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('type'); // service, topup, cart
            $table->text('items'); // JSON array of items purchased
            $table->integer('total_price');
            $table->string('payment_status')->default('pending'); // pending, paid, failed
            $table->string('payment_method')->default('whatsapp'); // whatsapp, doku
            $table->string('doku_invoice_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_packages');
        Schema::dropIfExists('games');
        Schema::dropIfExists('services');
        Schema::dropIfExists('orders');
    }
};
