import './bootstrap';
import hljs from 'highlight.js/lib/core';
import xml from 'highlight.js/lib/languages/xml';
import php from 'highlight.js/lib/languages/php';
import 'highlight.js/styles/atom-one-dark.css';

hljs.registerLanguage('xml', xml);
hljs.registerLanguage('php', php);
window.hljs = hljs;

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('pre code').forEach((block) => {
        hljs.highlightElement(block);
    });
});

document.addEventListener('livewire:navigated', () => {
    setTimeout(() => {
        document.querySelectorAll('pre code').forEach((block) => {
            hljs.highlightElement(block);
        });
    }, 100);
});
