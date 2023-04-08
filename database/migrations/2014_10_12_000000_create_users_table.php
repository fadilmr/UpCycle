<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->boolean('role')->default(0);
            $table->timestamps();
        });

        // add 1 record
        DB::table('users')->insert([
            'name' => 'John Doe',
            'username' => 'jon',
            'email' => 'jon@jon.com',
            'password' => Hash::make('password'),
            'phone_number' => '0123456789',
            'address' => '123 Street',
            'role' => 1,
        ]);

        // add 1 record
        DB::table('users')->insert([
            'name' => 'Fadil',
            'username' => 'diru',
            'email' => 'fadil@mail.com',
            'password' => Hash::make('asdasd'),
            'phone_number' => '0123456789',
            'address' => '123 Street',
            'role' => 0,
        ]);
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
