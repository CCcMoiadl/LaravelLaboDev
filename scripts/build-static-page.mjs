import { readFileSync, writeFileSync } from 'node:fs';
import { fileURLToPath } from 'node:url';
import path from 'node:path';

const rootDir = path.resolve(path.dirname(fileURLToPath(import.meta.url)), '..');

const manifest = JSON.parse(
    readFileSync(path.join(rootDir, 'public/build/manifest.json'), 'utf-8')
);

const cssFile = manifest['resources/css/app.css']?.file;
const jsFile = manifest['resources/js/app.js']?.file;

if (!cssFile || !jsFile) {
    throw new Error('Could not resolve built asset paths from the Vite manifest.');
}

const template = readFileSync(path.join(rootDir, 'resources/static/welcome.html'), 'utf-8');

const html = template
    .replaceAll('__APP_CSS__', `/build/${cssFile}`)
    .replaceAll('__APP_JS__', `/build/${jsFile}`);

writeFileSync(path.join(rootDir, 'public/index.html'), html);
