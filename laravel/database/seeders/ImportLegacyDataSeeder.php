<?php

namespace Database\Seeders;

class ImportLegacyDataSeeder extends LegacySqlSeeder
{
    /**
     * Legacy table => Laravel column mapping (dest => source).
     * Source "__NOW__" is replaced with the current timestamp.
     * Package tables and the admin table are handled elsewhere / excluded.
     */
    protected function tables(): array
    {
        return [
            'setting' => [
                'sitename' => 'sitename',
                'site_title' => 'site_title',
                'site_url' => 'site_url',
                'tracking_num' => 'tracking_num',
                'email_name' => 'email_name',
                'email_address' => 'email_address',
                'site_logo' => '::LIT::uploads/logo.png',
                'site_favicon' => '::LIT::uploads/favicon.png',
                'site_currency' => 'site_currency',
                'phone_number' => 'phone_number',
                'fax_number' => 'fax_number',
                'geocode_api_key' => 'geocode_api_key',
                'hero_subtitle' => 'hero_subtitle',
                'hero_title' => 'hero_title',
                'hero_text' => 'hero_text',
                'years_experience' => 'years_experience',
                'achievement_1_num' => 'achievement_1_num',
                'achievement_1_title' => 'achievement_1_title',
                'achievement_2_num' => 'achievement_2_num',
                'achievement_2_title' => 'achievement_2_title',
                'achievement_3_num' => 'achievement_3_num',
                'achievement_3_title' => 'achievement_3_title',
                'achievement_4_num' => 'achievement_4_num',
                'achievement_4_suffix' => 'achievement_4_suffix',
                'achievement_4_title' => 'achievement_4_title',
                'video_bg_image' => 'video_bg_image',
                'video_url' => 'video_url',
                'working_days' => 'working_days',
                'working_hours' => 'working_hours',
                'site_address' => 'site_address',
                'smtp_host' => 'smtp_host',
                'smtp_username' => 'smtp_username',
                'smtp_password' => 'smtp_password',
                'smtp_port' => 'smtp_port',
                'smtp_secure' => 'smtp_secure',
                'maintenance_mode' => 'maintenance_mode',
                'search_engine_indexing' => 'search_engine_indexing',
                'invoice_stamp' => 'invoice_stamp',
                'invoice_banner' => 'invoice_banner',
                'payment_methods_image' => 'payment_methods_image',
                'created_at' => '__NOW__',
                'updated_at' => '__NOW__',
            ],
            'services' => [
                'title' => 'title',
                'description' => 'description',
                'icon_class' => 'icon_class',
                'image' => 'image',
                'is_published' => 'is_published',
                'is_featured' => 'is_featured',
                'created_at' => 'created_at',
                'updated_at' => 'created_at',
            ],
            'team_members' => [
                'name' => 'name',
                'title' => 'title',
                'image' => 'image',
                'social_facebook' => 'social_facebook',
                'social_twitter' => 'social_twitter',
                'social_linkedin' => 'social_linkedin',
                'social_pinterest' => 'social_pinterest',
                'is_published' => 'is_published',
                'created_at' => 'created_at',
                'updated_at' => 'created_at',
            ],
            'testimonials' => [
                'name' => 'name',
                'title' => 'title',
                'image' => 'image',
                'review_text' => 'review_text',
                'rating' => 'rating',
                'is_published' => 'is_published',
                'created_at' => 'created_at',
                'updated_at' => 'created_at',
            ],
            'legal_pages' => [
                'page_slug' => 'page_slug',
                'page_title' => 'page_title',
                'page_content' => 'page_content',
                'created_at' => 'last_updated',
                'updated_at' => 'last_updated',
            ],
            'support_messages' => [
                'name' => 'name',
                'email' => 'email',
                'mobile' => 'mobile',
                'company' => 'company',
                'message' => 'message',
                'created_at' => 'created_at',
                'updated_at' => 'created_at',
            ],
            'geocache' => [
                'place' => 'place',
                'lat' => 'lat',
                'lon' => 'lon',
                'created_at' => 'updated_at',
                'updated_at' => 'updated_at',
            ],
        ];
    }
}
