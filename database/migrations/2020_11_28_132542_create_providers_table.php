<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
          $table->id();
          $table->string('name');
          $table->string('business_name');
          $table->foreignId('type_id');
          $table->string('email')->unique();
          $table->timestamp('email_verified_at')->nullable();
          $table->string('password');
          $table->string('contact')->unique();
          $table->string('address', '500');
          $table->string('locality');
          $table->float('latitude', 10, 7)->nullable();
          $table->float('longitude', 10, 7)->nullable();
          $table->dateTime('last_seen')->nullable();
          $table->string('summary', '1000')->nullable();
          $table->string('business_document')->nullable();
          $table->string('aadhar_card')->nullable();
          $table->string('profile_pic')->default('/images/profile-user.png');
          $table->integer('is_approved')->default(1);
          $table->integer('reviews_gained')->default(0);
          $table->rememberToken();
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
        Schema::dropIfExists('providers');
    }
}
