import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

// https://vite.dev/config/
export default defineConfig({
  server: {
    host: true,
    hmr: {
      clientPort: 5173,
    },
    watch: {
      usePolling: true,
    }
  },
  plugins: [react()],
})
