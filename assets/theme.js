(() => {
    'use strict'

    const THEME_AUTO = 'auto';
    const THEME_LIGHT = 'light';
    const THEME_DARK = 'dark';

    const getStoredTheme = () => localStorage.getItem('make-font-theme');
    const setStoredTheme = theme => localStorage.setItem('make-font-theme', theme);
    const getMediaTheme = () => window.matchMedia('(prefers-color-scheme: dark)').matches
        ? THEME_DARK
        : THEME_LIGHT;

    const getPreferredTheme = () => getStoredTheme() || getMediaTheme();

    const supportTransition = () => document.startViewTransition
        && !window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const setTheme = theme => {
        if (theme === THEME_AUTO) {
            theme = getMediaTheme();
        }

        const callback = () => document.documentElement.setAttribute('data-bs-theme', theme);
        if (supportTransition()) {
            document.startViewTransition(callback);
        } else {
            callback();
        }
    }

    setTheme(getPreferredTheme())

    const showActiveTheme = (theme) => {
        document.querySelectorAll('button[data-theme] .fa-check').forEach(element => {
            element.classList.remove('checked');
        })
        const source = document.querySelector(`button[data-theme="${theme}"] .fa-check`);
        if (source) {
            source.classList.add('checked');
        }
    }

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
        const storedTheme = getStoredTheme();
        if (storedTheme !== THEME_LIGHT && storedTheme !== THEME_DARK) {
            setTheme(getPreferredTheme());
        }
    })

    window.addEventListener('DOMContentLoaded', () => {
        showActiveTheme(getPreferredTheme());
        document.querySelectorAll('button[data-theme]').forEach(element => {
            element.addEventListener('click', () => {
                const theme = element.getAttribute('data-theme');
                showActiveTheme(theme);
                setStoredTheme(theme);
                setTheme(theme);
            })
        })
    })
})()
