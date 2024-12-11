window.loadPage = async function (page) {
    try {
        const response = await fetch(`/dashboard/${page}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        });
        if (!response.ok) {
            throw new Error("Page not found");
        }
        const html = await response.text();
        document.querySelector('#content').innerHTML = html;
        window.history.replaceState({ page }, '', `/dashboard`);

        loadScripts();
    } catch (error) {
        console.error('Error loading page:', error);
        document.querySelector('#content').innerHTML = `<h1>Error: ${error.message}</h1>`;
    }
};

function loadScripts() {
    // Reinitialize modalAdd.js functionality
    const modalScript = document.createElement('script');
    modalScript.src = '/assets/js/modalAdd.js';
    document.body.appendChild(modalScript);

    // Reinitialize pagination
    const paginationScript = document.createElement('script');
    paginationScript.src = '/assets/js/pagination.js';
    document.body.appendChild(paginationScript);
}
