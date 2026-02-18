import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: ['selector', '[data-theme="dark"]'],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Instrument Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: 'var(--color-primary)',
                'primary-light': 'var(--color-primary-light)',
                'primary-lighter': 'var(--color-primary-lighter)',
                background: 'var(--color-bg)',
                surface: 'var(--color-surface)',
                'surface-elevated': 'var(--color-surface-elevated)',
                border: 'var(--color-border)',
                foreground: 'var(--color-text)',
                muted: 'var(--color-text-secondary)',
                success: 'var(--color-success)',
                warning: 'var(--color-warning)',
                error: 'var(--color-error)',
                info: 'var(--color-info)',
            },
        },
    },

    plugins: [forms],
};
