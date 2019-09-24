<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddAptTypeToLawFirmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lawfirms', function (Blueprint $table) {
            //
            $table->string('apt_type'); //, ['none', 'apartment', 'suite', 'floor'])->default('none');
            $table->dropColumn('apartment');
            $table->dropColumn('suite');
            $table->dropColumn('floor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lawfirms', function (Blueprint $table) {
            //
            $table->dropColumn('apt_type');
            $table->boolean('apartment')->default(0);
            $table->boolean('suite')->default(0);
            $table->boolean('floor')->default(0);
        });
    }
}
