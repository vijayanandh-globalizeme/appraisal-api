<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_questions', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->string('name', 50);
            $table->string('label');
            $table->enum('status', ['TEXT','TEXTAREA','RADIO','CHECKBOX','SELECT','STAR']);
            $table->tinyInteger('isRequired')->default('1');
            $table->longText('options');
            $table->tinyInteger('status')->default('1');
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
        Schema::dropIfExists('review_questions');
    }
}
