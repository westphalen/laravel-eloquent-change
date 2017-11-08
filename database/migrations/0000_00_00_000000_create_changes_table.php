<?php
/**
 * Created by PhpStorm.
 * User: sune
 * Date: 08/11/2017
 * Time: 15.16
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('changes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('changeable_id');
            $table->string('changeable_type');
            $table->string('column')->index();
            $table->string('value');
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('applied_at')->nullable();

            $table->nullableTimestamps();

            $table->index(['changeable_id', 'changeable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('changes');
    }
}
