<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('roles', function (Blueprint $table) {
            $table->id(); // Primary Key (Auto Increment)
            $table->string('name')->unique(); // Role Name (Admin, User)
            $table->timestamps(); // Created_at & Updated_at
        });
    }

    public function down() {
        Schema::dropIfExists('roles');
    }
};
 