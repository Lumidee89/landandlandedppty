<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->decimal('land_length_ft', 12, 2)->nullable()->after('area_sqft');
            $table->decimal('land_width_ft', 12, 2)->nullable()->after('land_length_ft');
            $table->decimal('land_length_m', 12, 2)->nullable()->after('land_width_ft');
            $table->decimal('land_width_m', 12, 2)->nullable()->after('land_length_m');
            $table->decimal('area_sqm', 12, 2)->nullable()->after('land_width_m');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'land_length_ft',
                'land_width_ft',
                'land_length_m',
                'land_width_m',
                'area_sqm',
            ]);
        });
    }
};
