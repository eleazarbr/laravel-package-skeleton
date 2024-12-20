import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        vue(),
    ],
    publicDir: 'resources/assets',
    build: {
        outDir: 'dist',
        emptyOutDir: true,
        rollupOptions: {
          input: 'resources/js/app.js',
      },
    },
});