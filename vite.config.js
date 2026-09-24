import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';
import fs from 'fs';
import path from 'path';

function distBundlerPlugin() {
    return {
        name: 'dist-bundler-plugin',
        closeBundle() {
            const rootDir = process.cwd();
            const distDir = path.join(rootDir, 'dist');
            const legacyStaticDir = path.join(rootDir, 'legacy_static');
            const publicDir = path.join(rootDir, 'public');

            if (!fs.existsSync(distDir)) {
                fs.mkdirSync(distDir, { recursive: true });
            }

            if (fs.existsSync(legacyStaticDir)) {
                fs.cpSync(legacyStaticDir, distDir, { recursive: true });
            }

            if (fs.existsSync(publicDir)) {
                const items = fs.readdirSync(publicDir);
                for (const item of items) {
                    if (item === 'index.php' || item === '.htaccess') continue;
                    fs.cpSync(path.join(publicDir, item), path.join(distDir, item), { recursive: true });
                }
            }
        },
    };
}

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        tailwindcss(),
        distBundlerPlugin(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
