<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('icon');
            $table->boolean('active');
            $table->integer('refmenu');
            $table->integer('order');
            $table->enum('type', ['menu', 'submenu']);
            $table->string('grupo')->comment('de para');
            $table->string('atividade')->comment('de para');
            $table->string('aceitar')->comment('de para');
            $table->string('equipe')->comment('de para');
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
        Schema::dropIfExists('menu');
    }
}
