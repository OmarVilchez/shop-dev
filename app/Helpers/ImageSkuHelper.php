<?php

use App\Models\Image;
use App\Models\StockKeepingUnit;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (!function_exists('upload_sku_image_to_cloudinary')) {
    /**
     * Sube una imagen de un SKU a Cloudinary y la guarda en la tabla images.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param int $skuId
     * @param int $position
     * @return \App\Models\Image
     */
    function upload_sku_image_to_cloudinary($file, $skuId, $position = 0)
    {
        $publicId = "{$skuId}_" . Str::uuid(); // ejemplo: 2_64df7176...

        $response = Cloudinary::uploadApi()->upload(
            $file->getRealPath(),
            [
                'folder'        => "products/{$skuId}",
                'public_id'     => $publicId,
                'overwrite'     => true,
                'resource_type' => 'image',
                'format'        => 'webp',
               /*  'transformation' => [
                    'quality' => 'auto',
                    'fetch_format' => 'auto',
                ], */
            ]
        );

        return Image::create([
            'url'            => $response['secure_url'],   // URL Cloudinary
            'imageable_id'   => $skuId,
            'imageable_type' => StockKeepingUnit::class,
            'position'       => $position,
        ]);
    }
}

if (!function_exists('get_sku_image_url')) {
    /**
     * Obtiene la primera imagen de un SKU o un fallback.
     *
     * @param \App\Models\StockKeepingUnit $sku
     * @return string
     */
    function get_sku_image_url($sku)
    {
        if ($sku && $sku->images()->exists()) {
            return $sku->images()->first()->url;
        }

        // fallback local
        return Storage::url('no-image.png');
    }
}
