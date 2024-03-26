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
            $table->number('sticker_id');
            $table->string('description');
            $table->string('colors');
            $table->string('color');
            $table->string('shape');
            $table->number('family_id');
            $table->string('family_name');
            $table->string('team_name');
            $table->number('added');
            $table->number('pack_id');
            $table->string('pack_name');
            $table->number('pack_items');
            $table->string('tags');
            $table->number('equivalents');
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
