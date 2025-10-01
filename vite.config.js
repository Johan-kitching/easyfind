import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

import {viteStaticCopy} from 'vite-plugin-static-copy';

export default defineConfig({
    plugins: [
        viteStaticCopy({
            targets: [
                {
                    src: 'node_modules/google-address-autocomplete/dist/google-address-autocomplete.min.js',
                    dest: './',
                },
            ],
        }),
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        minify: true,
        sourcemap:false,
        rollupOptions: {
            output: {
                manualChunks: (path)=>{
                    if(path.includes('node_modules')) {
                        return 'vendor';
                    }
                },
            },
        }
    },
});
