<link rel="stylesheet" href="/assets/css/rank.css">
<script src="/assets/js/pagination.js"></script>

<body>
    <div class="container">
        <main>
            <div class="content-header">
                <h2>Rank</h2>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Name</th>
                        <th>NIM</th>
                        <th>Study Program</th>
                        <th><img src="../../assets/images/medal.png" alt="medal" width="20px"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($rankStudent)): ?>
                        <?php foreach ($rankStudent as $rank): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($rank['rank']); ?></td>
                                <td>
                                    <div class="avt-name">
                                        <div class="img-status">
                                            <img src="../../assets/images/avatar.png" alt="avatar" width="30px">
                                        </div>
                                        <p><?php echo htmlspecialchars($rank['student_name']); ?></p>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars($rank['student_nim']); ?></td>
                                <td><?php echo htmlspecialchars($rank['student_study_program']); ?></td>
                                <td><?php echo htmlspecialchars($totalRank['total_points']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No ranking data available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination">
                <button class="btn-pagination" data-page="prev">Prev</button>
                <?php
                $totalRows = count($rankStudent);
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

    </div>
</body>
