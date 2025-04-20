import 'bootstrap/dist/css/bootstrap.min.css';
import 'flag-icons/css/flag-icons.min.css';
import './styles/app.css';
import 'bootstrap';

(() => {
    'use strict'
    // const afmFile = document.getElementById('data_afmFile');
    // fontFile.addEventListener('change', () => {
    //     const required = fontFile.files.length !== 0
    //         && fontFile.files[0].name.endsWith('.pfb');
    //     // afmFile.required = required;
    //     //afmFile.disabled = !required
    // });

    const form = document.getElementById('data')
    const fontFile = document.getElementById('data_fontFile');
    const reset = document.querySelector('.btn-erase')
    const encoding = document.getElementById('data_encoding');
    const embed = document.getElementById('data_embed');
    const subset = document.getElementById('data_subset');

    form.addEventListener('submit', event => {
        document.querySelectorAll('.alert').forEach(element => {
            element.remove()
        })
        document.querySelectorAll('.invalid-feedback').forEach(element => {
            element.remove()
        })
        document.querySelectorAll('.is-invalid').forEach(element => {
            element.classList.remove('is-invalid')
        })
    });
    reset.addEventListener('click', () => {
        localStorage.removeItem('make-font-encoding');
        localStorage.removeItem('make-font-embed');
        localStorage.removeItem('make-font-subset');
        document.querySelectorAll('.alert').forEach(element => {
            element.remove()
        })
        document.querySelectorAll('.invalid-feedback').forEach(element => {
            element.remove()
        })
        document.querySelectorAll('.is-invalid').forEach(element => {
            element.classList.remove('is-invalid')
        })
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
