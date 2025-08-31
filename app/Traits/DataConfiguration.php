<?php

namespace App\Traits;

use App\Models\Configuration;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;

trait DataConfiguration
{
    public function socialmedia()
    {
        $keys = ['name_store', 'logo_store', 'logo_store_inv', 'email_contact', 'celular', 'whatsapp', 'facebook', 'instagram', 'tiktok', 'youtube' ];
        $configurations = Configuration::whereIn('key', $keys)->pluck('value', 'key');

        $this->name_store = $configurations['name_store'] ?? 'Mi tienda';
        $this->logo_store = $configurations['logo_store'] ?? 'logo.png';
        $this->logo_store_inv = $configurations['logo_store_inv'] ?? 'logo-inv.png';
        $this->email_contact = $configurations['email_contact'] ?? '';
        $this->celular = $configurations['celular'] ?? '';
        $this->whatsapp = $configurations['whatsapp'];
        $this->facebook = $configurations['facebook'] ?? '';
        $this->instagram = $configurations['instagram'] ?? '';
        $this->tiktok = $configurations['tiktok'] ?? '';
        $this->youtube = $configurations['youtube'] ?? '';
    }
}
