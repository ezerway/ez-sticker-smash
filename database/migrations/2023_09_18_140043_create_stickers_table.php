<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStickersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stickers', function (Blueprint $table) {
            $table->id();
            $table->integer('sticker_id');
            $table->string('description');
            $table->string('colors');
            $table->string('color');
            $table->string('shape');
            $table->integer('family_id');
            $table->string('family_name');
            $table->string('team_name');
            $table->integer('added');
            $table->integer('pack_id');
            $table->string('pack_name');
            $table->integer('pack_items');
            $table->string('tags');
            $table->integer('equivalents');
            $table->json('images');
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
        Schema::dropIfExists('stickers');
    }
}
