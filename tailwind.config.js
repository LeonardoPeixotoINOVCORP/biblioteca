import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
import daisyui from 'daisyui';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            keyframes:{
                fadeSlide: {
                    '0%' : { opacity: '0', transform: 'translateY(20px)' },
                    '100%' : { opacity: '1', transform: 'translateY(0px)'},
                },
            },
            animation:{
                'fade-slide' : 'fadeSlide 0.25s ease-out forwards',
            },
            maxWidth:{
                '7xl' : '96rem',
            }
        },
    },

    plugins: [forms, typography,daisyui],

    daisyui: {
        themes: ['light'],
    }
};
