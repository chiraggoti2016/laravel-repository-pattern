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
        Schema::create('project_cpu_counts', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->string('file')->comment('original file name');
            $table->string('newfile')->comment('new file name');
            $table->string('architecture')->nullable();
            $table->string('cpu_op_mode')->nullable();
            $table->string('byte_order')->nullable();
            $table->integer('cpu')->nullable();
            $table->string('on_line_cpu_list')->nullable();
            $table->integer('thread_per_core')->nullable();
            $table->integer('core_per_socket')->nullable();
            $table->integer('socket')->nullable();
            $table->integer('numa_node')->nullable();
            $table->string('vendor_id')->nullable();
            $table->string('cpu_family')->nullable();
            $table->string('model')->nullable();
            $table->string('model_name')->nullable();
            $table->integer('stepping')->nullable();
            $table->string('cpu_mhz')->nullable();
            $table->string('cpu_max_mhz')->nullable();
            $table->string('cpu_min_mhz')->nullable();
            $table->string('bogo_mips')->nullable();
            $table->string('hypervisor_vendor')->nullable();
            $table->string('virtualization')->nullable();
            $table->string('virtualization_type')->nullable();
            $table->string('l1d_cache')->nullable();
            $table->string('l1i_cache')->nullable();
            $table->string('l2_cache')->nullable();
            $table->string('l3_cache')->nullable();
            $table->string('numa_node0_cpu')->nullable();
            $table->string('numa_node1_cpu')->nullable();
            $table->text('flags')->nullable();
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
        Schema::dropIfExists('project_cpu_counts');
    }
};
