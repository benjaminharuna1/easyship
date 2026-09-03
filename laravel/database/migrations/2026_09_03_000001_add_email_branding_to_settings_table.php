<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('setting', function (Blueprint $table) {
            if (!Schema::hasColumn('setting', 'email_logo')) {
                $table->string('email_logo')->default('')->after('email_address');
            }
            if (!Schema::hasColumn('setting', 'email_primary_color')) {
                $table->string('email_primary_color', 20)->default('#041e42')->after('email_logo');
            }
            if (!Schema::hasColumn('setting', 'email_footer_text')) {
                $table->text('email_footer_text')->nullable()->after('email_primary_color');
            }
        });
    }

    public function down(): void
    {
        Schema::table('setting', function (Blueprint $table) {
            $columns = ['email_logo', 'email_primary_color', 'email_footer_text'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('setting', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
