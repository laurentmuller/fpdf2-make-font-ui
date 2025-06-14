import 'bootstrap/dist/css/bootstrap.css';
import './styles/app.css';
import 'bootstrap';

(() => {
    'use strict'

    const form = document.getElementById('data-form')
    const fontFile = document.getElementById('fontFile');
    const afmFile = document.getElementById('afmFile');
    const encoding = document.getElementById('encoding');
    const embed = document.getElementById('embed');
    const subset = document.getElementById('subset');
    const reset = document.getElementById('erase')
    const afmLabel = afmFile.parentElement.querySelector('label');

    const resetElements = function () {
        document.querySelectorAll('.alert, .invalid-feedback').forEach(element => {
            element.remove()
        })
        document.querySelectorAll('.is-invalid').forEach(element => {
            element.classList.remove('is-invalid')
        })
        afmLabel.classList.remove('required');
    }

    form.addEventListener('submit', () => {
        resetElements()
    });

    fontFile.addEventListener('change', () => {
        let required = false;
        if (fontFile.files.length) {
            const file = fontFile.files[0];
            const ext = file.name.split('.').pop();
            required = 'pfb' === ext.toLowerCase();
        }
        if (required) {
            afmFile.disabled = false;
            afmLabel.classList.add('required');
        } else {
            afmFile.disabled = true;
            afmLabel.classList.remove('required');
        }
    })

    reset.addEventListener('click', () => {
        localStorage.removeItem('make-font-encoding');
        localStorage.removeItem('make-font-embed');
        localStorage.removeItem('make-font-subset');
        resetElements()
        form.reset();
        fontFile.focus();
    })
    encoding.addEventListener('change', () => {
        localStorage.setItem('make-font-encoding', encoding.value);
    })
    embed.addEventListener('click', () => {
        localStorage.setItem('make-font-embed', JSON.stringify(embed.checked))
    })
    subset.addEventListener('click', () => {
        localStorage.setItem('make-font-subset', JSON.stringify(subset.checked))
    })

    document.querySelectorAll('.form-text.help-text').forEach(element => {
        const input = element.closest('div.mb-3').querySelector('input, select');
        element.addEventListener('click', () => {
            input.focus();
        })
    })

    let value = localStorage.getItem('make-font-encoding');
    if (value) {
        encoding.value = value
    }
    value = localStorage.getItem('make-font-embed')
    if (value) {
        embed.checked = JSON.parse(value)
    }
    value = localStorage.getItem('make-font-subset')
    if (value) {
        subset.checked = JSON.parse(value)
    }
})()
