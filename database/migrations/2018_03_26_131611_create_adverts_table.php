<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adverts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->enum('rubric', ['Детский мир', 'Недвижимость', 'Транспорт', 'Запчасти для транспорта', 'Работа', 'Животные', 'Электроника', 'Бизнес и услуги', 'Мода и стиль', 'Хобби отдых и спорт']);
            $table->string('description');
            $table->string('image_names')->nullable()->default('nofoto.jpg');
            $table->string('region');
            $table->string('phone')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('price')->unsigned()->default(0);
            $table->boolean('active')->default(false);
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
        Schema::dropIfExists('adverts');
    }
}
