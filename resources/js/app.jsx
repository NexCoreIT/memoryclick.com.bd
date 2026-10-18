import './bootstrap';
import '../css/app.css';

import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';

const appName = 'Memory Click';

// Robust helper to extract initial page payload from DOM
function getPagePayload() {
    if (typeof window === 'undefined') return undefined;

    // 1. Modern Inertia JSON script element
    const scriptEl = document.querySelector('script[data-page="app"][type="application/json"]');
    if (scriptEl && scriptEl.textContent) {
        try {
            return JSON.parse(scriptEl.textContent);
        } catch (e) {
            console.error('Failed to parse Inertia script data-page:', e);
        }
    }

    // 2. Classic Inertia div[data-page] element
    const appEl = document.getElementById('app');
    if (appEl && appEl.dataset && appEl.dataset.page) {
        try {
            return JSON.parse(appEl.dataset.page);
        } catch (e) {
            console.error('Failed to parse Inertia element dataset.page:', e);
        }
    }

    return undefined;
}

const initialPage = getPagePayload();

createInertiaApp({
    id: 'app',
    page: initialPage,
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) => {
        const pages = import.meta.glob('./Pages/**/*.jsx', { eager: true });
        const page = pages[`./Pages/${name}.jsx`];
        if (!page) {
            throw new Error(`Page "./Pages/${name}.jsx" not found.`);
        }
        return page.default || page;
    },
    setup({ el, App, props }) {
        const root = createRoot(el);
        root.render(<App {...props} />);
    },
    progress: {
        color: '#EAA636',
        showSpinner: true,
    },
});
