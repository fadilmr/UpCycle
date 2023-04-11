<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('product_title');
            $table->string('product_description');
            $table->integer('product_price');
            $table->string('product_category');
            $table->timestamps();
        });

        // insert data
        DB::table('products')->insert([
            [
                'user_id' => 1,
                'product_title' => 'Product 1',
                'product_description' => 'Product 1 Description',
                'product_price' => 10000,
                'product_category' => 'Category 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'product_title' => 'Product 2',
                'product_description' => 'Product 2 Description',
                'product_price' => 20000,
                'product_category' => 'Category 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'product_title' => 'Product 3',
                'product_description' => 'Product 3 Description',
                'product_price' => 30000,
                'product_category' => 'Category 3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'product_title' => 'Product 4',
                'product_description' => 'Product 4 Description',
                'product_price' => 40000,
                'product_category' => 'Category 4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'product_title' => 'Product 5',
                'product_description' => 'Product 5 Description',
                'product_price' => 50000,
                'product_category' => 'Category 5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
