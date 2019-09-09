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
            $table->string('color', 50);
            $table->string('material', 50);
            $table->json('images');
            $table->json('options');
            $table->timestamps();
        });
    

        /**
         * Settings Table
         */
        Schema::create('settings', function (Blueprint $table) {
            $table->string('name');
            $table->json('content');
            $table->timestamps();

            $table->primary('name');
        });

        /**
         * Customers Table
         */
        Schema::create('customers', function (Blueprint $table) {
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email', 100);
            $table->string('password');
            $table->string('remember_token', 100)->nullable();
            $table->longText('address');
            $table->enum('gender', ['male', 'female']);
            $table->json('phone_numbers');
            $table->enum('activation_status', ['yes', 'no'])->default('no');
            $table->enum('newsletters', ['yes', 'no'])->defualt('yes');
            $table->json('shopping_cart')->nullable();
            $table->json('liked_items')->nullable();
            $table->timestamps(); 

            //add primary key
            $table->primary('email');
            
        });

        /**
         * Orders Table
         */
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');
            $table->string('product_size', 100);
            $table->integer('product_quantity');
            $table->string('customer_email', 100);
            $table->string('staff_email', 100)->nullable();
            $table->enum('status', ["pending", "delivered", "failed"])->default("pending");
            $table->dateTime('est_del_date')->comment('estimated delivery date')->nullable();
            $table->dateTime('failure_date')->nullable();
            $table->string("failure_cause", 200)->default('');
            $table->dateTime('delivery_date')->nullable();
            $table->timestamps();

            //Foreign keys
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('customer_email')->references('email')->on('customers');
        });

        /**
         * Staffs Table
         */
        Schema::create('staffs', function (Blueprint $table) {
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email', 100);
            $table->string('password');
            $table->string('remember_token', 100)->nullable();
            $table->string('api_token', 80)->nullable();
            $table->longText('address');
            $table->enum('gender', ['male', 'female']);
            $table->json('phone_numbers');
            $table->enum('privilege_level', ['staff', 'admin'])->default('staff');
            $table->timestamps();

            //add primary key
            $table->primary('email');

            
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
        //DELETE IMAGES
        $images_arrays= DB::table('products')->pluck('images');
        $images_array= $images_arrays->flatten();

        foreach($images_array as $imagepatharray){

            $imagepatharray= json_decode($imagepatharray);
     
            foreach($imagepatharray as $imagepath){
                 Storage::delete($imagepath);
            }
        }

        
        Schema::dropIfExists('settings');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('staffs');
    }
}
