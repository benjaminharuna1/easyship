<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('setting', function (Blueprint $table) {
            if (!Schema::hasColumn('setting', 'show_contact_map')) {
                $table->boolean('show_contact_map')->default(true)->after('email_footer_text');
            }
        });
    }

    public function down(): void
    {
        Schema::table('setting', function (Blueprint $table) {
            if (Schema::hasColumn('setting', 'show_contact_map')) {
                $table->dropColumn('show_contact_map');
            }
        });
    }
};
