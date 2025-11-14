<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactFormLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_form_logs', function (Blueprint $table) {
            $table->id();
            $table->integer("contractor_id");
            $table->string("name");
            $table->string("email");
            $table->string("state")->nullable();
            $table->string("zip_code")->nullable();
            $table->integer("interest_in_buy")->nullable();
            $table->integer("interest_in_floor_plan")->nullable();
            $table->integer("number_of_home")->nullable();
            $table->integer("budget")->nullable();
            $table->integer("time_frame")->nullable();
            $table->string("comment")->nullable();
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
        Schema::dropIfExists('contact_form_logs');
    }
}