<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('setting', function (Blueprint $table) {
            $table->id();
            $table->string('sitename');
            $table->string('site_title');
            $table->string('site_url');
            $table->string('tracking_num')->default('');
            $table->string('email_name');
            $table->string('email_address');
            $table->string('site_logo')->default('');
            $table->string('site_favicon')->default('');
            $table->string('site_currency', 10)->default('$');
            $table->string('phone_number')->nullable();
            $table->string('fax_number')->nullable();
            $table->string('geocode_api_key')->nullable();
            $table->string('hero_subtitle')->default('Smart Solutions');
            $table->text('hero_title')->nullable();
            $table->text('hero_text')->nullable();
            $table->integer('years_experience')->default(10);
            $table->integer('achievement_1_num')->default(250);
            $table->string('achievement_1_title')->default('Team member');
            $table->integer('achievement_2_num')->default(300);
            $table->string('achievement_2_title')->default('Complete project');
            $table->integer('achievement_3_num')->default(450);
            $table->string('achievement_3_title')->default('Winning award');
            $table->integer('achievement_4_num')->default(1);
            $table->string('achievement_4_suffix', 10)->default('k');
            $table->string('achievement_4_title')->default('Worldwide clients');
            $table->string('video_bg_image')->default('assets/img/resource/video-one__img1.jpg');
            $table->string('video_url')->default('https://www.youtube.com/watch?v=06dV9txztKY');
            $table->string('working_days')->nullable();
            $table->string('working_hours')->nullable();
            $table->text('site_address')->nullable();
            $table->string('smtp_host')->default('');
            $table->string('smtp_username')->default('');
            $table->string('smtp_password')->default('');
            $table->integer('smtp_port')->default(587);
            $table->string('smtp_secure')->default('tls');
            $table->integer('email_on_creation')->default(0);
            $table->integer('email_on_update')->default(0);
            $table->boolean('maintenance_mode')->default(false);
            $table->boolean('search_engine_indexing')->default(true);
            $table->string('invoice_stamp')->nullable();
            $table->string('invoice_banner')->nullable();
            $table->string('payment_methods_image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('setting');
    }
};
