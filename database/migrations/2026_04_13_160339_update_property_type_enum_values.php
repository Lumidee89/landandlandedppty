<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // For MySQL 8.0+
        DB::statement("ALTER TABLE properties MODIFY COLUMN property_type ENUM('bungalow', 'duplex', 'apartment', 'block_of_flat', 'mansion', 'townhouse', 'commercial', 'land') NOT NULL");
    }

    public function down()
    {
        DB::statement("ALTER TABLE properties MODIFY COLUMN property_type ENUM('apartment', 'house', 'land', 'commercial', 'villa', 'townhouse') NOT NULL");
    }
};