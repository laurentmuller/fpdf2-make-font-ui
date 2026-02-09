(() => {
    'use strict'

    const THEME_AUTO = 'auto';
    const THEME_LIGHT = 'light';
    const THEME_DARK = 'dark';
    const STORAGE_KEY = 'make-font-theme';
    const MEDIA_THEME = '(prefers-color-scheme: dark)';

    const getStoredTheme = () => localStorage.getItem(STORAGE_KEY);
    const setStoredTheme = theme => localStorage.setItem(STORAGE_KEY, theme);
    const getMediaTheme = () => window.matchMedia(MEDIA_THEME).matches ? THEME_DARK : THEME_LIGHT;
    const getPreferredTheme = () => getStoredTheme() || getMediaTheme();

    const supportTransition = () => document.startViewTransition
        && !window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const setTheme = (theme, transition = true) => {
        if (theme === THEME_AUTO) {
            theme = getMediaTheme();
        }

        const callback = () => document.documentElement.dataset.bsTheme = theme;
        if (transition && supportTransition()) {
            document.startViewTransition(callback);
        } else {
            callback();
        }
    }

    setTheme(getPreferredTheme(), false);

    const showActiveTheme = (theme) => {
        document.querySelectorAll('button[data-theme] .fa-check').forEach(element => {
            element.classList.remove('checked');
        })
        const source = document.querySelector(`button[data-theme="${theme}"] .fa-check`);
        if (source) {
            source.classList.add('checked');
        }
    }

    window.matchMedia(MEDIA_THEME).addEventListener('change', () => {
        const storedTheme = getStoredTheme();
        if (storedTheme !== THEME_LIGHT && storedTheme !== THEME_DARK) {
            setTheme(getPreferredTheme());
        }
    })

    window.addEventListener('DOMContentLoaded', () => {
        showActiveTheme(getPreferredTheme());
        document.querySelectorAll('button[data-theme]').forEach(element => {
            element.addEventListener('click', () => {
                const theme = element.dataset.theme;
                showActiveTheme(theme);
                setStoredTheme(theme);
                setTheme(theme);
            })
        })
    })
})()
