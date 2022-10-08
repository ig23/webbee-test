<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration
{
    /** ToDo: Create a migration that creates all tables for the following user stories

    For an example on how a UI for an api using this might look like, please try to book a show at https://in.bookmyshow.com/.
    To not introduce additional complexity, please consider only one cinema.

    Please list the tables that you would create including keys, foreign keys and attributes that are required by the user stories.

    ## User Stories

     **Movie exploration**
     * As a user I want to see which films can be watched and at what times
     * As a user I want to only see the shows which are not booked out

     **Show administration**
     * As a cinema owner I want to run different films at different times
     * As a cinema owner I want to run multiple films at the same time in different showrooms

     **Pricing**
     * As a cinema owner I want to get paid differently per show
     * As a cinema owner I want to give different seat types a percentage premium, for example 50 % more for vip seat

     **Seating**
     * As a user I want to book a seat
     * As a user I want to book a vip seat/couple seat/super vip/whatever
     * As a user I want to see which seats are still available
     * As a user I want to know where I'm sitting on my ticket
     * As a cinema owner I dont want to configure the seating for every show
     */
    public function up()
    {   

        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['viewer', 'admin']);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('movies', function($table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->integer('duration_min');
            $table->string('type');
            $table->timestamps();
        });

        Schema::create('cinema', function($table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('seat_no');
            $table->timestamps();
        });

        Schema::create('cinemaMovie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained('movies');
            $table->foreignId('cinema_id')->constrained('cinema');
            $table->dateTime('showTime');
            $table->float('price');
            $table->timestamps();
        });

        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->int('seat_no')->constrained('movies');
            $table->enum('category', ['vip', 'super', 'vip-couple']);
            $table->foreignId('cinema_id')->constrained('cinema');
            $table->enum('status', ['available', 'reserve']);
            $table->timestamps();
        });

         Schema::create('booking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('show_id')->constrained('cinemaMovie');
            $table->foreignId('seat_id')->constrained('seats');
            $table->foreignId('viewer_id')->constrained('user');

            $table->timestamps();
        });





        throw new \Exception('implement in coding task 4, you can ignore this exception if you are just running the initial migrations.');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::dropIfExists('movies');
    }
}
