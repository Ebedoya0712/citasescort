<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            [
                'key' => 'site_name',
                'label' => 'Nombre del Sitio',
                'value' => 'Citasescort',
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'site_logo',
                'label' => 'Logo del Sitio',
                'value' => null,
                'type' => 'image',
                'group' => 'general',
            ],
            [
                'key' => 'footer_text',
                'label' => 'Texto del Footer',
                'value' => 'Â© 2026 Citasescort. Todos los derechos reservados.',
                'type' => 'textarea',
                'group' => 'general',
            ],
            // SEO
            [
                'key' => 'seo_title',
                'label' => 'TÃ­tulo SEO (Meta Title)',
                'value' => 'Citasescort - Escorts VIP en Uruguay',
                'type' => 'text',
                'group' => 'seo',
            ],
            [
                'key' => 'seo_description',
                'label' => 'DescripciÃ³n SEO',
                'value' => 'Encuentra las mejores escorts verificadas en Uruguay.',
                'type' => 'textarea',
                'group' => 'seo',
            ],
            // Payments - MercadoPago
            [
                'key' => 'mercadopago_access_token',
                'label' => 'MercadoPago Access Token',
                'value' => 'APP_USR-...',
                'type' => 'text',
                'group' => 'payment',
            ],
            [
                'key' => 'mercadopago_public_key',
                'label' => 'MercadoPago Public Key',
                'value' => 'APP_USR-...',
                'type' => 'text',
                'group' => 'payment',
            ],
            // Payments - PayPal
            [
                'key' => 'paypal_client_id',
                'label' => 'PayPal Client ID',
                'value' => '',
                'type' => 'text',
                'group' => 'payment',
            ],
            [
                'key' => 'paypal_secret',
                'label' => 'PayPal Secret',
                'value' => '',
                'type' => 'text',
                'group' => 'payment',
            ],
            [
                'key' => 'enable_payments',
                'label' => 'Habilitar Pagos en LÃ­nea',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'payment',
            ],
            // Social
            [
                'key' => 'facebook_url',
                'label' => 'Facebook URL',
                'value' => 'https://facebook.com/citasescort',
                'type' => 'text',
                'group' => 'social',
            ],
            [
                'key' => 'instagram_url',
                'label' => 'Instagram URL',
                'value' => 'https://instagram.com/citasescort',
                'type' => 'text',
                'group' => 'social',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(['key' => $setting['key']], $setting);
        }
    }
}

