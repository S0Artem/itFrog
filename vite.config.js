import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',  // Путь к вашему основному JS файлу
                'resources/css/app.css', // Путь к вашему основному CSS файлу (если он есть)
            ],
        }),
    ],
});