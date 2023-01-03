<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploadables', function (Blueprint $table) {
            $table->id();
            // Polymorphic relationship
            // It is important to note that the uploadable_type and uploadable_id columns are linked to the uploadable() method in the Upload model
            // If the name is changed, the method name must be changed as well
            $table->unsignedInteger('upload_id');
            $table->unsignedInteger('uploadable_id')->nullable();
            $table->string('uploadable_type')->nullable();
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
        Schema::dropIfExists('uploadables');
    }
};
