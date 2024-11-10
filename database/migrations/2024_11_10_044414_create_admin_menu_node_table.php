<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_menu_node', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->integer('pid', false, true)->nullable(false)->default(0)->index()->comment('父节点id');
            $table->tinyInteger('level', false, true)->nullable(false)->comment('节点层次')->default(1);
            $table->string('title', 20)->nullable(false)->comment('菜单节点名称');
            $table->string('url', 20)->nullable(false)->comment('节点url地址');
            $table->tinyInteger('is_show', false, true)->comment('该节点是否展示0:不展示 1:展示')->default(1)->nullable(false);
            $table->tinyInteger('is_delete', false, true)->comment('该节点是否被软删除0:否 1:是')->default(0)->nullable(false);
            $table->integer('create_time', false, true)->comment('创建时间');
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_menu_node');
    }
};
