<!DOCTYPE html>
<html lang="en">

<head>
    <script src="/resources/js/load-page.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>

<body>
    <?php require_once '../resources/views/components/navbar.html'; ?>

    <div id="content">
        <!-- Initial content can be loaded here if needed -->
    </div>

    <script>
        const loadPage = window.loadPage;

        window.addEventListener('load', () => {
            const lastPage = localStorage.getItem('currentPage') || 'home';

            const navLink = document.querySelector(`.navlink .link[href="${lastPage}"]`);
            if (navLink) {
                navLink.click();
            }
        });

        document.querySelectorAll('.navlink .link').forEach(link => {
            link.addEventListener('click', async function(e) {
                e.preventDefault();
                const page = this.getAttribute('href');
                localStorage.setItem('currentPage', page);
                await window.loadPage(page);
            });
        });

        window.onpopstate = function(event) {
            if (event.state && event.state.page) {
                window.loadPage(event.state.page);
            } else {
                const lastPage = localStorage.getItem('currentPage') || 'home';
                window.loadPage(lastpage);
            }
        }

        // Load last visited page or default to home
        const initialPage = localStorage.getItem('currentPage') || 'home';
        window.loadPage(initialPage);
    </script>
</body>

</html>
