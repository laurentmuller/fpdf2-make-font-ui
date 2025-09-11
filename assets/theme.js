(() => {
    'use strict'

    const THEME_AUTO = 'auto';
    const THEME_LIGHT = 'light';
    const THEME_DARK = 'dark';

    const TEXT_SELECTOR = '.theme-text';
    const ICON_SELECTOR = '.theme-icon';
    const ICON_ATTRIBUTE = 'href';

    const getStoredTheme = () => localStorage.getItem('make-font-theme')
    const setStoredTheme = theme => localStorage.setItem('make-font-theme', theme)
    const getMediaTheme = () => window.matchMedia('(prefers-color-scheme: dark)').matches
        ? THEME_DARK
        : THEME_LIGHT

    const getPreferredTheme = () => getStoredTheme() || getMediaTheme()

    const setTheme = theme => {
        if (theme === THEME_AUTO) {
            theme = getMediaTheme()
        }
        document.documentElement.setAttribute('data-bs-theme', theme)
    }

    setTheme(getPreferredTheme())

    const showActiveTheme = (theme, focus = false) => {
        document.querySelectorAll('button[data-theme]').forEach(element => {
            element.setAttribute('aria-pressed', 'false')
            element.classList.remove('active')
        })

        const source = document.querySelector(`button[data-theme="${theme}"]`)
        const sourceIcon = source.querySelector(ICON_SELECTOR)
        const sourceText = source.querySelector(TEXT_SELECTOR)
        source.setAttribute('aria-pressed', 'true')
        source.classList.add('active')

        const target = document.getElementById('theme-switcher')
        const targetIcon = target.querySelector(ICON_SELECTOR)
        const targetText = target.querySelector(TEXT_SELECTOR)
        targetText.textContent = sourceText.textContent
        targetIcon.setAttribute(ICON_ATTRIBUTE, sourceIcon.getAttribute(ICON_ATTRIBUTE));
        target.setAttribute('aria-label', sourceText.textContent)

        if (focus) {
            target.focus()
        }
    }

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
        const storedTheme = getStoredTheme()
        if (storedTheme !== THEME_LIGHT && storedTheme !== THEME_DARK) {
            setTheme(getPreferredTheme())
        }
    })

    window.addEventListener('DOMContentLoaded', () => {
        showActiveTheme(getPreferredTheme())
        document.querySelectorAll('button[data-theme]').forEach(element => {
            element.addEventListener('click', () => {
                const theme = element.getAttribute('data-theme')
                showActiveTheme(theme, true)
                setStoredTheme(theme)
                setTheme(theme)
            })
        })
    })
})()
