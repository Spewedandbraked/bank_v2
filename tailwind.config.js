import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            keyframes: {
                appear: {
                    "0%": {
                        opacity: "1",
                    },
                    '70%': {
                        opacity: '1',
                    },
                    "100%": {
                        opacity: "0",
                        display: 'none',
                    },
                },
            },
            animation: {
                appear: "appear 2.5s ease-in-out forwards",
            }

        },
        colors: {
            user: '#020617',
            admin: '#3730a3',
            error: '#ff0000',
            success: '#00ff00'
        }

    },

    plugins: [forms],
};
