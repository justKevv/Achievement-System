<!DOCTYPE html>
<html lang="en">

<head>
    <script src="/assets/js/load-page.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>

<body>
    <?php require_once '../resources/views/components/navbar.php'; ?>

    <div id="content">
        <!-- Initial content can be loaded here if needed -->
    </div>

    <script>
        const loadPage = window.loadPage;

        async function handlePageLoad(page) {
            const link = document.querySelector(`.navlink .link[href="${page}"]`);
            if (link) {
                // Update navbar before loading page
                updateSelectablePosition(link);
                localStorage.setItem('lastClickedLink', link.textContent);
            }
            await window.loadPage(page);
        }

        window.addEventListener('load', () => {
            const lastPage = localStorage.getItem('currentPage') || 'home';
            handlePageLoad(lastPage);
        });

        document.querySelectorAll('.navlink .link').forEach(link => {
            link.addEventListener('click', async function(e) {
                e.preventDefault();
                const page = this.getAttribute('href');
                localStorage.setItem('currentPage', page);
                updateSelectablePosition(this); // Add this line
                await handlePageLoad(page);
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
