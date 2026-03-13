<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColorSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('color_settings', function (Blueprint $table) {
            $table->id(); 
            $table->string('body_color')->nullable();
            $table->string('header_color')->nullable();
            $table->string('footer_color')->nullable();
            $table->string('headings_color')->nullable();
            $table->string('heading_background_color')->nullable();
            $table->string('label_color')->nullable();
            $table->string('paragraph_color')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('color_settings');
    }
}
