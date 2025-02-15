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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->text('asset_name');
            $table->unsignedBigInteger('asset_category_id'); // Foreign key to AssetCategory
            $table->unsignedBigInteger('asset_sub_category_id'); // Foreign key to AssetSubCategory
            $table->string('asset_image')->nullable(); // Asset image path
            $table->integer('quantity')->default(0);
            $table->decimal('pricing', 10, 2)->default(0);
            $table->integer('in_use')->default(0);
            $table->integer('in_stock')->default(0);
            $table->integer('is_disabled')->default(0);
            $table->integer('is_lost')->default(0);
            $table->enum('lost_approved', ['Anup Saha', 'Devjit Saha'])->nullable();
            $table->date('warranty_from')->nullable();
            $table->date('warranty_to')->nullable();
            $table->text('note')->nullable();
            $table->enum('status', ['on', 'off'])->default('on');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('asset_category_id')->references('id')->on('asset_categories')->onDelete('cascade');
            $table->foreign('asset_sub_category_id')->references('id')->on('asset_sub_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
