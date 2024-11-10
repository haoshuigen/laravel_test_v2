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
        Schema::create('admin_role_nodes', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->integer('role_id', false, true)->nullable(false)->comment('角色id');
            $table->integer('node_id', false, true)->nullable(false)->comment('节点id');
            $table->integer('create_time', false, true)->comment('创建时间');
            $table->unique(['role_id', 'node_id'], 'uniq_role_node');
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_role_nodes');
    }
};
