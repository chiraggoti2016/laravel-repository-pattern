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
        Schema::create('cpu_count_details', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->integer('hostname_id');
            $table->integer('cpu_count_id');
            $table->string('architecture')->nullable();
            $table->string('op_modes')->nullable();
            $table->string('byte_order')->nullable();
            $table->string('cpus')->nullable();
            $table->string('on_line_cpus_list')->nullable();
            $table->integer('threads_per_core')->nullable();
            $table->integer('cores_per_socket')->nullable();
            $table->integer('sockets')->nullable();
            $table->integer('numa_nodes')->nullable();
            $table->string('vendor_id')->nullable();
            $table->integer('cpu_family')->nullable();
            $table->integer('model')->nullable();
            $table->string('model_name')->nullable();
            $table->integer('stepping')->nullable();
            $table->string('cpu_mhz')->nullable();
            $table->string('cpu_max_mhz')->nullable();
            $table->string('cpu_min_mhz')->nullable();
            $table->string('hypervisor_vendor')->nullable();
            $table->string('virtualization_type')->nullable();
            $table->string('bogo_mips')->nullable();
            $table->string('virtualization')->nullable();
            $table->string('l1d_cache')->nullable();
            $table->string('l1i_cache')->nullable();
            $table->string('l2_cache')->nullable();
            $table->string('l3_cache')->nullable();
            $table->string('numa_node0_cpus')->nullable();
            $table->string('numa_node1_cpus')->nullable();
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
        Schema::dropIfExists('cpu_count_details');
    }
};
