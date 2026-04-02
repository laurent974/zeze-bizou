import { defineConfig } from 'vite';
import dotenv from 'dotenv';
import path from 'path';

dotenv.config();

export default defineConfig({
  root: `public/themes/${process.env.WP_DEFAULT_THEME}/app`,
  base: './',
  resolve: {
    alias: {
      '@': path.resolve(__dirname, `public/themes/${process.env.WP_DEFAULT_THEME}/app`) // @ = dossier app
    }
  },
  build: {
    assetsDir: '',
    emptyOutDir: true,
    manifest: true,
    outDir: `../dist`,
    rollupOptions: {
      input: {
        main: path.resolve(__dirname, `public/themes/${process.env.WP_DEFAULT_THEME}/app/js/main.js`)
      }
    },
  },
});
