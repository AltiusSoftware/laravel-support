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

        Schema::create('record_roles', function (Blueprint $table) {
            $table->increments('id');

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

			$table->string('role',16);
            $table->morphs('securable');


        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('record_roles');
       
    }
};
