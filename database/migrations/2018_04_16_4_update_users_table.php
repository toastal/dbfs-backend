<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->boolean('is_active')->default(true);
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_deleted')->default(false);
            $table->string('date_of_birth')->nullable();
            $table->string('account_number')->nullable();
            $table->string('address')->nullable();
            $table->string('avatar')->nullable();
            $table->string('city')->nullable();
            $table->string('mobile')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->timestamp('last_login')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('father_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('temporary_address')->nullable();
            $table->string('id_proof')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('occupation')->nullable();
            $table->string('qualification')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_relationship')->nullable();
            $table->string('emergency_phone_number')->nullable();
            $table->string('joining_date')->nullable();
            $table->string('reference_id')->nullable();
            $table->index('is_active');
            $table->index('is_deleted');
            $table->index('is_admin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('account_number'); 
            $table->dropColumn('address');
            $table->dropColumn('avatar');
            $table->dropColumn('city');
            $table->dropColumn('date_of_birth');
            $table->dropColumn('is_active');
            $table->dropColumn('is_admin');
            $table->dropColumn('last_login');
            $table->dropColumn('mobile');
            $table->dropColumn('postal_code');
            $table->dropColumn('state');
            $table->dropColumn('father_name');
            $table->dropColumn('gender');
            $table->dropColumn('temporary_address');
            $table->dropColumn('id_proof');
            $table->dropColumn('blood_group');
            $table->dropColumn('height');
            $table->dropColumn('weight');
            $table->dropColumn('occupation');
            $table->dropColumn('qualification');
            $table->dropColumn('emergency_contact_name');
            $table->dropColumn('emergency_relationship');
            $table->dropColumn('emergency_phone_number');
            $table->dropColumn('joining_date');
            $table->dropColumn('reference_id');
        });
    }
}
