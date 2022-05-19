<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('admin');
        Schema::create('admin', function (Blueprint $table) {
            $table->id('aid');
            $table->unsignedBigInteger('guid');
            $table->string('fullname',255);
            $table->string('username',20);
            $table->string('password',255);
            $table->string('pin',6);
            $table->string('email',255)->nullable();
            $table->enum('active',['y','n'])->default('n');
            $table->enum('online',['y','n'])->default('n');
            $table->text('last_login_data')->nullable();
            $table->rememberToken();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();

            $table->foreign('guid')
                ->references('guid')
                ->on('admin_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin');
    }
}
