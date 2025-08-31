import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        //cors: true,
        host: 'shop-dev.test', // <- tu dominio local personalizado
        port: 5174,            // <- el puerto por defecto de Vite
        https: false,           // <- si no usas HTTPS localmente
        origin: 'http://shop-dev.test:5174', // <- 👈 clave para evitar errores de origen
        cors: true,
    },
});
