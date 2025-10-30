import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        // Pindai HANYA file-file yang menggunakan Tailwind:
        './resources/views/layouts/guest.blade.php', // Layout Login/Register Breeze
        './resources/views/auth/**/*.blade.php',     // Semua view di folder auth
        './resources/views/dashboard.blade.php',     // Halaman dashboard
        './resources/views/profile/**/*.blade.php',  // Halaman profil
        './app/Filament/**/*.php',                  // Panel Admin Filament
        './resources/views/vendor/filament/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [forms],
};
