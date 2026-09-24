import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const rootDir = __dirname;
const distDir = path.join(rootDir, 'dist');
const legacyStaticDir = path.join(rootDir, 'legacy_static');
const publicDir = path.join(rootDir, 'public');

// Ensure dist directory is clean
if (fs.existsSync(distDir)) {
    fs.rmSync(distDir, { recursive: true, force: true });
}
fs.mkdirSync(distDir, { recursive: true });

// 1. Copy all static pages and scripts from legacy_static to dist
if (fs.existsSync(legacyStaticDir)) {
    fs.cpSync(legacyStaticDir, distDir, { recursive: true });
}

// 2. Copy compiled public assets (including vite build assets, favicon, robots) into dist
if (fs.existsSync(publicDir)) {
    const publicItems = fs.readdirSync(publicDir);
    for (const item of publicItems) {
        if (item === 'index.php' || item === '.htaccess') continue;
        const srcPath = path.join(publicDir, item);
        const destPath = path.join(distDir, item);
        fs.cpSync(srcPath, destPath, { recursive: true });
    }
}

console.log('✓ Successfully generated dist/ directory for Vercel deployment.');
