<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumers', function (Blueprint $table) {
          $table->id();
          $table->string('name');
          $table->string('email')->unique();
          $table->string('password');
          $table->string('contact');
          $table->string('address', '500');
          $table->string('locality');
          $table->float('latitude', 10, 7)->nullable();
          $table->float('longitude', 10, 7)->nullable();
          $table->string('profile_pic')->default('/images/profile-user.png');
          $table->integer('reviews_given')->default(0);
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
        Schema::dropIfExists('consumers');
    }
}
