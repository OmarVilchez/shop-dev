<?php

if (! function_exists('cloudinaryUrl')) {
    /**
     * Agregar transformaciones a una URL de Cloudinary
     *
     * @param string|null $url      URL original devuelta por Cloudinary
     * @param array       $options  Ej: ['q' => 'auto', 'f' => 'auto', 'w' => 400, 'h' => 300, 'c' => 'fill']
     * @return string|null
     */
    function cloudinaryUrl(?string $url, array $options = []): ?string
    {
        if (!$url) {
            return null;
        }

        // Construir la parte de transformaciones tipo: q_auto,f_auto,w_400,h_300,c_fill
        $transforms = collect($options)->map(function ($value, $key) {
            return "{$key}_{$value}";
        })->implode(',');

        // Insertar transformaciones en la URL después de "upload/"
        return str_replace('/upload/', "/upload/{$transforms}/", $url);
    }
}
