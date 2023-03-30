import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'
import alias from '@rollup/plugin-alias'
import { resolve } from 'path'
const projectRootDir = resolve(__dirname);

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            
        }),
        vue(),
        alias(),
    ],
    resolve: {
        alias: {
          "@": resolve(projectRootDir, "resources/js/component"),
        },
    },
});
