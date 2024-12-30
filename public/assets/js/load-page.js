window.loadPage = async function (page) {
    try {
        const cleanPage = page.replace(/^\/dashboard\//, '');

        const response = await fetch(`/dashboard/${cleanPage}`, {
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

        $('.jquery-modal').remove();

        // Single modal initialization for home page
        if (page === 'home') {
            const isFirstVisit = !sessionStorage.getItem('modalShown');
            console.log('Is first visit:', isFirstVisit);

            if (isFirstVisit) {
                const modal = $('#pending-modal');
                console.log('Modal found:', modal.length);

                if (modal.length) {
                    modal.modal({
                        fadeDuration: 300,
                        showClose: true,
                        escapeClose: false,
                        clickClose: false,
                        closeExisting: true
                    });
                    sessionStorage.setItem('modalShown', 'true');
                }
            }
        }

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
