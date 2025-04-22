import 'bootstrap/dist/css/bootstrap.min.css';
import './styles/app.css';
import 'bootstrap';

(() => {
    'use strict'
    // const afmFile = document.getElementById('afmFile');
    // fontFile.addEventListener('change', () => {
    //     const required = fontFile.files.length !== 0
    //         && fontFile.files[0].name.endsWith('.pfb');
    //     // afmFile.required = required;
    //     //afmFile.disabled = !required
    // });

    const form = document.getElementById('data')
    const fontFile = document.getElementById('fontFile');
    const encoding = document.getElementById('encoding');
    const embed = document.getElementById('embed');
    const subset = document.getElementById('subset');
    const reset = document.getElementById('erase')

    const resetElements = function () {
        document.querySelectorAll('.alert, .invalid-feedback').forEach(element => {
            element.remove()
        })
        document.querySelectorAll('.is-invalid').forEach(element => {
            element.classList.remove('is-invalid')
        })
    }
    form.addEventListener('submit', event => {
        resetElements()
    });
    reset.addEventListener('click', () => {
        localStorage.removeItem('make-font-encoding');
        localStorage.removeItem('make-font-embed');
        localStorage.removeItem('make-font-subset');
        resetElements()
        form.reset();
        fontFile.focus();
        // document.getElementById('fontFile').dispatchEvent(new Event('change'));
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
