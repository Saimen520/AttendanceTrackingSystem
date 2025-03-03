 <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->string('name');
            $table->string('ic_passport')->unique();
            $table->date('dob');
            $table->string('contact_no');
            $table->text('address');
            $table->string('email')->unique();
            $table->string('password');
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade'); // Foreign Key
             $table->integer('role')->after('email'); // Add role column
                $table->string('rfid_uid')->nullable()->unique(); // Add RFID UID column
            $table->timestamps();
        });
    }

    public function down() {
        Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('role');
        });
    }
};
