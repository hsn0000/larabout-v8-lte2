<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminModuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('admin_module');
        Schema::create('admin_module', function (Blueprint $table) {
            $table->id('modid');
            $table->bigInteger('parent_id');
            $table->integer('mod_order')->nullable();
            $table->string('mod_name')->nullable();
            $table->string('mod_alias')->nullable();
            $table->string('mod_icon')->nullable();
            $table->string('permalink')->nullable();
            $table->enum('published',['y','n'])->default('n');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_module');
    }
}
