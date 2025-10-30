import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            // INI ADALAH PERUBAHAN PENTING:
            // Kita tambahkan 'resources/css/app.css' ke array input
            input: [
                'resources/scss/app.scss', // Untuk Storefront (Bootstrap)
                'resources/css/app.css',   // Untuk Breeze/Filament (Tailwind)
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
        }
    }
});
