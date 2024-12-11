<link rel="stylesheet" href="/assets/css/navbar.css">
<div class="contain">
    <div class="logo-contain">
        <img class="logo" src="/assets/images/logo-sars.png" alt="Logo SARS">
    </div>
    <div class="navbar">
        <div class="white-pill <?php echo isset($_SESSION['role_id']) ? match ($_SESSION['role_id']) {
                                    'A' => 'admin-pill',
                                    'S' => 'student-pill',
                                    'C' => 'chairman-pill',
                                    default => ''
                                } : ''; ?>"></div>
        <div class="selectable"></div>
        <div class="navlink">
            <?php if ($_SESSION['role_id'] === 'A'): ?>
                <a href="home" class="link">Dashboard</a>
                <a href="approval" class="link">Approval</a>
                <a href="user" class="link">User</a>
            <?php elseif ($_SESSION['role_id'] === 'S'): ?>
                <a href="home" class="link">Dashboard</a>
                <a href="submission" class="link">Submission</a>
                <a href="rank" class="link">Rank</a>
            <?php elseif ($_SESSION['role_id'] === 'C'): ?>
                <a href="home" class="link">Dashboard</a>
                <a href="studentdata" class="link">Student</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="two-icon">
        <img src="/assets/icons/notification.png" alt="" class="notification">
        <a href="/logout" onclick="localStorage.clear()">
            <img src="/assets/icons/log-out.png" alt="" class="log-out">
        </a>
    </div>
</div>

<script>
    function updateSelectablePosition(link) {
        const selectableDiv = document.querySelector('.selectable');
        const linkLeft = link.offsetLeft;
        const roleId = '<?php echo $_SESSION['role_id'] ?>';

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
                'Student': '155px',
            }
        };

        const width = widthMap[roleId]?.[link.textContent] || '0px';
        selectableDiv.style.width = width;
    }

    window.addEventListener('load', () => {
        console.log('Window Loaded');
        const lastClickedLink = localStorage.getItem('lastClickedLink');
        console.log(lastClickedLink);
        if (lastClickedLink) {
            const link = Array.from(document.querySelectorAll('.navlink .link')).find(link => link.textContent === lastClickedLink);
            if (link) {
                const selectableDiv = document.querySelector('.selectable');
                selectableDiv.style.transition = 'none';
                updateSelectablePosition(link);
                selectableDiv.offsetHeight; // Trigger reflow
                selectableDiv.style.transition = 'left 0.5s ease, width 0.5s ease';
            }
        }
    });
</script>
