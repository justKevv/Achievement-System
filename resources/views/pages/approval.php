<link rel="stylesheet" href="/assets/css/approval.css">
<script defer src="/assets/js/pagination.js"></script>

<script>
    window.openAchievementModal = function(element) {
        console.log('Modal trigger clicked for Achievement ID:', element.getAttribute('data-achievement-id'));
        const modal = document.getElementById('detail-modal');
        if (modal) {
            modal.style.display = 'flex';
            // Optional: Add a class for CSS display handling
            modal.classList.add('show');
        } else {
            console.error('Modal element not found');
        }
    }

    window.toggleDetail = function() {
        const modal = document.getElementById('detail-modal');
        if (modal) {
            modal.style.display = 'none';
            modal.classList.remove('show');
        }
    }
</script>

<body>
    <div class="approval-page">
        <div class="container">
            <main>
                <div class="content-header">
                    <h2>Achievement Verification</h2>
                    <div class="actions">
                        <div class="search">
                            <input type="text" placeholder="Search">
                            <button class="search-btn"><img src="/assets/icons/search.png" alt="Search"></button>
                        </div>
                        <div class="filter" onclick="toggleFilter()">
                            <button class="filter-btn">Filter</button>
                            <img src="/assets/icons/filter.png" alt="Filter">
                        </div>
                    </div>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Competition Title</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($adminAchievements as $index => $achievement): ?>
                            <tr>
                                <td><?php echo $index + 1 ?></td>
                                <td><?php echo htmlspecialchars($achievement['student_name']) ?></td>
                                <td><?php echo htmlspecialchars($achievement['achievement_title']) ?></td>
                                <td><?php echo htmlspecialchars($achievement['achievement_category']) ?></td>
                                <td><?php echo htmlspecialchars($achievement['achievement_date']) ?></td>
                                <td>
                                    <div class="status <?php echo strtolower($achievement['achievement_status']) ?>"
                                        data-achievement-id="<?php echo $achievement['achievement_id'] ?>"
                                        data-title="<?php echo htmlspecialchars($achievement['achievement_title']) ?>"
                                        data-description="<?php echo htmlspecialchars($achievement['achievement_description']) ?>"
                                        data-category="<?php echo htmlspecialchars($achievement['achievement_category']) ?>"
                                        data-date="<?php echo htmlspecialchars($achievement['achievement_date']) ?>"
                                        data-organizer="<?php echo htmlspecialchars($achievement['achievement_organizer']) ?>"
                                        data-certificate="<?php echo htmlspecialchars($achievement['certificate_file'] ?? '') ?>"
                                        data-documentation="<?php echo htmlspecialchars($achievement['documentation_file'] ?? '') ?>"
                                        data-certificate-type="<?php echo pathinfo($achievement['achievement_certifications'] ?? '', PATHINFO_EXTENSION) ?: 'png' ?>"
                                        data-documentation-type="<?php echo pathinfo($achievement['achievement_activities_documentation'] ?? '', PATHINFO_EXTENSION) ?: 'png' ?>"
                                        style="cursor: pointer;">
                                        <div class="img-status">
                                            <img src="../../assets/icons/<?php echo strtolower($achievement['achievement_status']) ?>.png" alt="">
                                        </div>
                                        <p><?= ucfirst($achievement['achievement_status']) ?></p>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination">
                    <button class="btn-pagination" data-page="prev">Prev</button>
                    <?php
                    $totalRows = count($adminAchievements); // Assuming $users is your data array
                    $pages = ceil($totalRows / 10);
                    for ($i = 1; $i <= $pages; $i++) {
                        $activeClass = ($i === 1) ? 'active' : 'btn-pagination';
                        echo "<button class='$activeClass' data-page='$i'>$i</button>";
                    }
                    ?>
                    <button class="btn-pagination" data-page="next">Next</button>
                </div>
            </main>
        </div>

        <!-- Filter Modal -->
        <div class="filter-modal" id="filter-modal">
            <div class="filter-content">
                <div class="header-filter">
                    <h3>Filter</h3>
                    <button class="close-btn" onclick="toggleFilter()">✖</button>
                </div>
                <form>
                    <div class="form-input">
                        <div class="input-field">
                            <div class="label">
                                <label for="category">Category</label>
                                <p>Clear</p>
                            </div>
                            <input type="text" id="category">
                        </div>
                        <div class="input-field">
                            <div class="label">
                                <label for="status">Status</label>
                                <p>Clear</p>
                            </div>
                            <input type="text" id="status">
                        </div>
                    </div>
                    <div class="modal-actions">
                        <button id="reset-btn" type="button" onclick="resetFilterApproval()">Reset</button>
                        <button id="apply-btn" type="submit">Apply</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Input Achievement Modal -->
        <div class="achievement-detail" id="detail-modal" data-achievement-id="">
            <div class="achievement-detail-content">
                <div class="header-detail">
                    <h3>Achievement Verification</h3>
                    <button class="close-btn" onclick="toggleDetail()">✖</button>
                </div>
                <div class="detail-content">
                    <div class="right-detail">
                        <div class="detail">
                            <p>Competition Title</p>
                            <p id="modal-title">TechFest Hackathon 2024</p>
                        </div>
                        <div class="detail">
                            <p>Description</p>
                            <p id="modal-description">1st Place in App Development Competition</p>
                        </div>
                        <div class="detail">
                            <p>Category</p>
                            <p id="modal-category">International</p>
                        </div>
                        <div class="detail">
                            <p>Date</p>
                            <p id="modal-date">2024/09/10</p>
                        </div>
                    </div>
                    <div class="left-detail">
                        <div class="detail">
                            <p>Organizer</p>
                            <p id="modal-organizer">International</p>
                        </div>
                        <div class="detail">
                            <p>Certificate</p>
                            <img id="modal-certificate" src="" alt="">
                        </div>
                        <div class="detail">
                            <p>Activity Documentation</p>
                            <img id="modal-documentation" src="" alt="">
                        </div>
                    </div>
                </div>
                <div class="detail-actions">
                    <?php if ($achievement['achievement_status'] === 'Approved'): ?>
                        <p class="verification-info">
                            Approved by: <?php echo htmlspecialchars($achievement['verification_by']); ?><br>
                            on <?php echo date('d M Y H:i', strtotime($achievement['verification_at'])); ?>
                        </p>
                    <?php elseif ($achievement['achievement_status'] === 'Rejected'): ?>
                        <p class="rejected-info">
                            Rejected by: <?php echo htmlspecialchars($achievement['verification_by']); ?><br>
                            on <?php echo date('d M Y H:i', strtotime($achievement['verification_at'])); ?>
                        </p>
                    <?php else: ?>
                        <button id="reject" type="button" onclick="handleReject()">Reject</button>
                        <button id="approve" type="button" onclick="handleApprove()">Approve</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

</body>
