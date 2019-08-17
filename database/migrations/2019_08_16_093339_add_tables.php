<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTables extends Migration
{
    /**
     * Run the migrations.
     * 
     * Create database tables for API
     *
     * @return void
     */
    public function up()
    {
        /**
         * Products Table
         */
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->string('brand', 50);
            $table->longText('description'); 
            $table->string('section', 100);
            $table->string('sub_section', 50);
            $table->string('category', 50);
            $table->double('price', 12, 2);
            $table->string('material', 50);
            $table->json('images');
            $table->json('options');
            $table->timestamps();
        });
    

        /**
         * Settings Table
         */
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('content');
            $table->timestamps();
        });

        /**
         * Customers Table
         */
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email', 100);
            $table->longText('password');
            $table->longText('address');
            $table->enum('gender', ['male', 'female']);
            $table->json('phone_numbers');
            $table->enum('activation_status', ['yes', 'no'])->default('no');
            $table->enum('newsletters', ['yes', 'no'])->defualt('yes');
            $table->json('shopping_cart')->nullable();
            $table->json('liked_items')->nullable();
            $table->longText('remember_token')->nullable();
            $table->timestamps(); 
            
        });

        /**
         * Orders Table
         */
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');
            $table->string('product_color', 100);
            $table->string('product_size', 100);
            $table->integer('product_quantity');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->enum('status', ["pending", "delivered", "failed"])->default("pending");
            $table->dateTime('est_del_date')->comment('estimated delivery date')->nullable();
            $table->dateTime('failure_date')->nullable();
            $table->string("failure_cause", 200)->default('');
            $table->dateTime('delivery_date')->nullable();
            $table->timestamps();

            //Foreign keys
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('customer_id')->references('id')->on('customers');
        });

        /**
         * Staffs Table
         */
        Schema::create('staffs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email', 100);
            $table->longText('password');
            $table->longText('address');
            $table->enum('gender', ['male', 'female']);
            $table->json('phone_numbers');
            $table->enum('privilege_level', ['staff', 'admin'])->default('staff');
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
        Schema::dropIfExists('orders');
        Schema::dropIfExists('products');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('staffs');
    }
}
