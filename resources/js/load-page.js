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
        window.history.pushState({ page }, '', `/dashboard`);
    } catch (error) {
        console.error('Error loading page:', error);
        document.querySelector('#content').innerHTML = `<h1>Error: ${error.message}</h1>`;
    }
};
