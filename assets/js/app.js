const app = document.getElementById('app');

async function loadPage(url, push = true) {
    const params = new URL(url, window.location.origin);

    try {
        const response = await fetch(
            `page.php${params.search}`
        );

        if (!response.ok) {
            throw new Error('Failed to load page');
        }

        app.innerHTML = await response.text();

        const pageElement = app.firstElementChild;

        if (pageElement?.dataset.pageTitle) {
            document.title =
                `${pageElement.dataset.pageTitle} | Result Board`;
        }

        if (typeof initAddResult === 'function') {
            initAddResult();
        }

        if (typeof initEditResult === 'function') {
            initEditResult();
        }

        if (push) {
            history.pushState(
                {},
                '',
                params.search || '?page=dashboard'
            );
        }
    } catch (error) {
        console.error(error);
        app.innerHTML = '<p>Failed to load content.</p>';
    }
}

document.addEventListener('click', event => {
    const link = event.target.closest('a[href^="?page="]');

    if (!link) return;

    event.preventDefault();

    loadPage(link.href);
});

window.addEventListener('popstate', () => {
    loadPage(window.location.href, false);
});