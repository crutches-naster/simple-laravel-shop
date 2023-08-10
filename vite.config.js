import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        hmr: {
            host: 'localhost',
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.scss',
                'resources/js/app.js',
                'resources/js/payment/paypal.js',
                'resources/admin/css/app.scss',
                'resources/admin/ja/app.js',
            ],
            refresh: true,
        }),
    ],
});
