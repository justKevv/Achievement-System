<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>

<body>
    <?php require_once '../resources/views/components/navbar.html'; ?>

    <div id="content">
        <!-- Dynamic content loads here -->
        <?php
        $page = $_GET['page'] ?? 'home';
        switch ($page) {
            case 'home':
                require_once '../resources/views/pages/home.php';
                break;
            case 'rank':
                require_once '../resources/views/pages/rank.php';
                break;
            case 'submission':
                require_once '../resources/views/pages/submission.php';
                break;
        }
        ?>
    </div>
    <script>
        let currentPage = 'home';

        document.querySelectorAll('.navlink .link').forEach(link => {
            link.addEventListener('click', async (e) => {
                e.preventDefault();
                const page = link.getAttribute('href').replace('/', '');
                currentPage = page;

                try {
                    // Keep URL clean
                    const response = await fetch('/dashboard', {
                        headers: {
                            'X-Requested-Page': page // Optional: Send page info in header
                        }
                    });
                    const html = await response.text();
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const content = doc.querySelector('#content').innerHTML;

                    document.querySelector('#content').innerHTML = content;
                    // Keep URL constant
                    window.history.pushState({
                        page
                    }, '', '/dashboard');
                } catch (error) {
                    console.error('Error:', error);
                }
            });
        });

        window.onpopstate = function(event) {
            if (event.state && event.state.page) {
                currentPage = event.state.page;
                updateContent(currentPage);
            }
        };

        function updateContent(page) {
            fetch('/dashboard', {
                    headers: {
                        'X-Requested-Page': page
                    }
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const content = doc.querySelector('#content').innerHTML;
                    document.querySelector('#content').innerHTML = content;
                });
        }
    </script>

</body>

</html>
