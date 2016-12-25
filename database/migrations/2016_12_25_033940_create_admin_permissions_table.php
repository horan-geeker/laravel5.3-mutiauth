<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('admin_id')->comment('管理员id');
            $table->unsignedInteger('permission_id')->comment('权限id');

            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_permissions');
    }
}
