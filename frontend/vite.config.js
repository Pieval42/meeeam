import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [react()],
  test: {
    globals: true,
    environment: 'jsdom',
    exclude: [
      '**/node_modules/**',
      '**/selenium/**'
    ],
    coverage: {
      provider: 'v8',
      exclude: [
        '**/node_modules/**',
        '**/selenium/**'
      ]
    }
  },
  build: {
    outDir: '../dist'
  },
  server: {
    port: 8080
  }
})
