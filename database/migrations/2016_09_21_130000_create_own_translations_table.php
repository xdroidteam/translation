<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOwnTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('locale');
            $table->string('group');
            $table->string('key');
            $table->text('translation')->nullable();
            $table->integer('status')->default(0);
            $table->dateTime('last_touch')->nullable();
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
        //
    }
}
