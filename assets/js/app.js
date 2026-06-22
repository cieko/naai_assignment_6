// Main container where page content is rendered
const app = document.getElementById('app');

// Load a page without refreshing the browser
async function loadPage(url, push = true) {

    // Extract query parameters from the URL
    const params = new URL(url, window.location.origin);

    try {

        // Request page content from page.php
        const response = await fetch(
            `page.php${params.search}`
        );

        if (!response.ok) {
            throw new Error('Failed to load page');
        }

        // Replace current page content
        app.innerHTML = await response.text();

        const pageElement = app.firstElementChild;

        // Update browser tab title
        if (pageElement?.dataset.pageTitle) {
            document.title =
                `${pageElement.dataset.pageTitle} | Result Board`;
        }

        // Re-initialize Add Result page functionality
        if (typeof initAddResult === 'function') {
            initAddResult();
        }

        // Re-initialize Edit Result modal functionality
        if (typeof initEditResult === 'function') {
            initEditResult();
        }

        // Update browser history so Back/Forward works
        if (push) {
            history.pushState(
                {},
                '',
                params.search || '?page=dashboard'
            );
        }

    } catch (error) {

        console.error(error);

        // Show error message if page fails to load
        app.innerHTML = '<p>Failed to load content.</p>';
    }
}

// Handle navigation links without full page reload
document.addEventListener('click', event => {

    const link = event.target.closest('a[href^="?page="]');

    if (!link) return;

    event.preventDefault();

    loadPage(link.href);
});

// Handle browser Back and Forward buttons
window.addEventListener('popstate', () => {
    loadPage(window.location.href, false);
});