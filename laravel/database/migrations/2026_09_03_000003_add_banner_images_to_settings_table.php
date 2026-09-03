<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('setting', function (Blueprint $table) {
            if (!Schema::hasColumn('setting', 'home_banner_image')) {
                $table->string('home_banner_image')->default('')->after('show_contact_map');
            }
            if (!Schema::hasColumn('setting', 'page_banner_image')) {
                $table->string('page_banner_image')->default('')->after('home_banner_image');
            }
        });
    }

    public function down(): void
    {
        Schema::table('setting', function (Blueprint $table) {
            $columns = ['home_banner_image', 'page_banner_image'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('setting', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
