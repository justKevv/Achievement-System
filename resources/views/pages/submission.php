<link rel="stylesheet" href="/assets/css/submission.css">
<script src="/assets/js/script.js"></script>

<body>
    <div class="container">
        <main>
            <div class="content-header">
                <h2>Achievement Submission</h2>
                <div class="actions">
                    <div class="search">
                        <input type="text" placeholder="Search">
                        <button class="search-btn"><img src="/assets/icons/search.png" alt="Search"></button>
                    </div>
                    <div class="filter" onclick="toggleFilter()">
                        <button class="filter-btn">Filter</button>
                        <img src="/assets/icons/filter.png" alt="Filter">
                    </div>
                    <button class="add-btn" onclick="toggleDetail()">+ Add Achievement</button>
                </div>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Competition Title</th>
                        <th>Category</th>
                        <th>Organizer</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($studentAchievements as $index => $achievement): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($achievement['achievement_title']) ?></td>
                            <td><?= htmlspecialchars($achievement['achievement_category']) ?></td>
                            <td><?= htmlspecialchars($achievement['achievement_organizer']) ?></td>
                            <td><?= htmlspecialchars($achievement['achievement_date']) ?></td>
                            <td>
                                <div class="status <?= strtolower($achievement['achievement_status']) ?>"
                                    data-achievement-id="<?= $achievement['achievement_id'] ?>"
                                    data-title="<?= htmlspecialchars($achievement['achievement_title']) ?>"
                                    data-description="<?= htmlspecialchars($achievement['achievement_description']) ?>"
                                    data-category="<?= htmlspecialchars($achievement['achievement_category']) ?>"
                                    data-date="<?= htmlspecialchars($achievement['achievement_date']) ?>"
                                    data-organizer="<?= htmlspecialchars($achievement['achievement_organizer']) ?>"
                                    data-certificate="<?= $achievement['certificate_file'] ?? '' ?>"
                                    data-documentation="<?= $achievement['documentation_file'] ?? '' ?>"
                                    data-status="<?= htmlspecialchars($achievement['achievement_status']) ?>"
                                    data-verification-by="<?= htmlspecialchars($achievement['verification_by'] ?? '') ?>"
                                    data-verification-at="<?= isset($achievement['verification_at']) ? date('d M Y H:i', strtotime($achievement['verification_at'])) : '' ?>"
                                    style="cursor: pointer;"
                                    onclick="openViewModal(this)">
                                    <div class="img-status">
                                        <img src="/assets/icons/<?= strtolower($achievement['achievement_status']) ?>.png" alt="">
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
                $totalRows = count($studentAchievements); // Assuming $studentAchievements is your data array
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
    <div class="achievement-detail" id="detail-modal">
        <div class="achievement-detail-content">
            <div class="header-detail">
                <h3>Input Achievement Data</h3>
                <button class="close-btn" onclick="toggleDetail()">✖</button>
            </div>
            <form id="achievementForm" action="/achievement/create" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                <div class="detail-content">
                    <div class="right-detail">
                        <div class="detail">
                            <p>Competition Title</p>
                            <input type="text" name="title" required>
                        </div>
                        <div class="detail">
                            <p>Description</p>
                            <input type="text" name="description" required>
                        </div>
                        <div class="detail">
                            <p>Category</p>
                            <select name="category" required>
                                <option value="Regional">Regional</option>
                                <option value="National">National</option>
                                <option value="International">International</option>
                            </select>
                        </div>
                        <div class="detail">
                            <p>Date</p>
                            <input type="date" name="date" required>
                        </div>
                    </div>
                    <div class="left-detail">
                        <div class="detail">
                            <p>Organizer</p>
                            <input type="text" name="organizer" required>
                        </div>
                        <div class="detail">
                            <p>Certificate</p>
                            <input type="file" id="certificate" name="certificate" accept=".pdf,.jpg,.jpeg,.png" required>
                            <span>Max size 5Mb</span>
                        </div>
                        <div class="detail">
                            <p>Activity Documentation</p>
                            <input type="file" id="activities" name="activities" accept=".pdf,.jpg,.jpeg,.png" required>
                            <span>Max size 5Mb</span>
                        </div>
                    </div>
                </div>
                <div class="detail-actions">
                    <button type="submit" id="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- View Achievement Modal -->
    <div class="achievement-detail" id="view-modal">
        <div class="achievement-detail-content">
            <div class="header-detail">
                <h3>Achievement Details</h3>
                <button class="close-btn" onclick="toggleViewModal()">✖</button>
            </div>
            <div class="detail-content">
                <div class="right-detail">
                    <div class="detail">
                        <p>Competition Title</p>
                        <p id="view-title"></p>
                    </div>
                    <div class="detail">
                        <p>Description</p>
                        <p id="view-description"></p>
                    </div>
                    <div class="detail">
                        <p>Category</p>
                        <p id="view-category"></p>
                    </div>
                    <div class="detail">
                        <p>Date</p>
                        <p id="view-date"></p>
                    </div>
                </div>
                <div class="left-detail">
                    <div class="detail">
                        <p>Organizer</p>
                        <p id="view-organizer"></p>
                    </div>
                    <div class="detail">
                        <p>Certificate</p>
                        <img id="view-certificate" src="" alt="">
                    </div>
                    <div class="detail">
                        <p>Activity Documentation</p>
                        <img id="view-documentation" src="" alt="">
                    </div>
                </div>
            </div>
            <div class="detail-status">
                <?php if ($achievement['achievement_status'] === 'Approved'): ?>
                    <p class="verification-info">
                        Approved by: <?php echo isset($achievement['verification_by']) ? htmlspecialchars($achievement['verification_by']) : 'System'; ?><br>
                        on <?php echo isset($achievement['verification_at']) ? date('d M Y H:i', strtotime($achievement['verification_at'])) : '-'; ?>
                    </p>
                <?php elseif ($achievement['achievement_status'] === 'Rejected'): ?>
                    <p class="rejected-info">
                        Rejected by: <?php echo isset($achievement['verification_by']) ? htmlspecialchars($achievement['verification_by']) : 'System'; ?><br>
                        on <?php echo isset($achievement['verification_at']) ? date('d M Y H:i', strtotime($achievement['verification_at'])) : '-'; ?>
                    </p>
                <?php elseif ($achievement['achievement_status'] === 'Pending'): ?>
                    <p class="pending-info">Waiting for verification</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('achievementForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const submitButton = document.getElementById('submit');
            submitButton.disabled = true;
            submitButton.textContent = 'Submitting...';

            try {
                const formData = new FormData(e.target);

                const response = await fetch('/achievement/create', {
                    method: 'POST',
                    body: formData,
                    redirect: 'follow'
                });

                if (response.redirected) {
                    window.location.href = response.url;
                    return;
                }

                const contentType = response.headers.get('content-type');
                const result = contentType?.includes('application/json') ?
                    await response.json() : {
                        success: false,
                        error: 'Invalid response'
                    };

                if (result.success) {
                    alert('Achievement submitted successfully');
                    document.getElementById('achievementForm').reset();
                    window.location.href = '/dashboard';
                } else {
                    throw new Error(result.error || 'Submission failed');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error submitting achievement: ' + error.message);
            } finally {
                submitButton.disabled = false;
                submitButton.textContent = 'Submit';
            }
        });
    </script>
</body>
