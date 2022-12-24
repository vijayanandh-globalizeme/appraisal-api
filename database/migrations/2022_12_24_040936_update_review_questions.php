<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateReviewQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('review_questions', function($table) {
            $table->enum('type', ['TEXT', 'TEXTAREA', 'RADIO', 'CHECKBOX', 'SELECT', 'STAR'])->default('TEXT')->after('label');
            $table->text('options')->nullable()->after('type');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
