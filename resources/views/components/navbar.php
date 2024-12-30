<link rel="stylesheet" href="/assets/css/navbar.css">
<div class="contain">
    <div class="logo-contain">
        <img class="logo" src="/assets/images/logo-sars.png" alt="Logo SARS">
    </div>
    <div class="navbar" data-role="<?php echo $_SESSION['role_id'] ?? ''; ?>">
        <div class="white-pill <?php echo isset($_SESSION['role_id']) ? match ($_SESSION['role_id']) {
                                    'A' => 'admin-pill',
                                    'S' => 'student-pill',
                                    'C' => 'chairman-pill',
                                    default => ''
                                } : ''; ?>"></div>
        <div class="selectable"></div>
        <div class="navlink">
            <?php if ($_SESSION['role_id'] === 'A'): ?>
                <a href="/dashboard/home" class="link" data-page="home">Dashboard</a>
                <a href="/dashboard/approval" class="link" data-page="approval">Approval</a>
                <a href="/dashboard/user" class="link" data-page="user">User</a>
            <?php elseif ($_SESSION['role_id'] === 'S'): ?>
                <a href="/dashboard/home" class="link" data-page="home">Dashboard</a>
                <a href="/dashboard/submission" class="link" data-page="submission">Submission</a>
                <a href="/dashboard/rank" class="link" data-page="rank">Rank</a>
            <?php elseif ($_SESSION['role_id'] === 'C'): ?>
                <a href="/dashboard/home" class="link" data-page="home">Dashboard</a>
                <a href="/dashboard/studentdata" class="link" data-page="studentdata">Student</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="two-icon">
        <a href="/logout" onclick="sessionStorage.removeItem('modalShown'); localStorage.clear()">
            <img src="/assets/icons/log-out.png" alt="" class="log-out">
        </a>
    </div>
</div>

<script>
    function updateSelectablePosition(link) {
        const selectableDiv = document.querySelector('.selectable');
        const linkLeft = link.offsetLeft;
        const roleId = '<?php echo $_SESSION['role_id'] ?>';
        const currentPath = window.location.pathname;

        if (currentPath === '/profile') {
            selectableDiv.style.width = '0px';
            return;
        }

        console.log("Updating link: ", linkLeft);

        selectableDiv.style.left = `${linkLeft}px`;

        const widthMap = {
            'A': { // Admin
                'Dashboard': '185px',
                'Approval': '165px',
                'User': '130px'
            },
            'S': { // Student
                'Dashboard': '185px',
                'Submission': '185px',
                'Rank': '130px'
            },
            'C': {
                'Dashboard': '185px',
                'Student': '160px',
            }
        };

        const width = widthMap[roleId]?.[link.textContent] || '0px';
        selectableDiv.style.width = width;
    }

    window.addEventListener('load', () => {
        console.log('Window Loaded');
        const currentPath = window.location.pathname;
        const currentPage = localStorage.getItem('currentPage') || 'home';

        if (currentPath === '/profile') {
            const selectableDiv = document.querySelector('.selectable');
            selectableDiv.style.width = '0px';
            return;
        }

        const currentLink = Array.from(document.querySelectorAll('.navlink .link'))
            .find(link => link.getAttribute('data-page') === currentPage);

        if (currentLink) {
            const selectableDiv = document.querySelector('.selectable');
            selectableDiv.style.transition = 'none';
            updateSelectablePosition(currentLink);
            selectableDiv.offsetHeight; // Trigger reflow
            selectableDiv.style.transition = 'left 0.5s ease, width 0.5s ease';
        }

        // const lastClickedLink = localStorage.getItem('lastClickedLink');
        // console.log(lastClickedLink);
        // if (lastClickedLink) {
        //     const link = Array.from(document.querySelectorAll('.navlink .link')).find(link => link.textContent === lastClickedLink);
        //     if (link) {
        //         const selectableDiv = document.querySelector('.selectable');
        //         selectableDiv.style.transition = 'none';
        //         updateSelectablePosition(link);
        //         selectableDiv.offsetHeight; // Trigger reflow
        //         selectableDiv.style.transition = 'left 0.5s ease, width 0.5s ease';
        //     }
        // }
    });
</script>
