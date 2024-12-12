<link rel="stylesheet" href="/assets/css/rank.css">
<?php
error_log("rankingAdmin in view: " . print_r($rankingAdmin ?? [], true));
?>

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
                                <td><?php echo htmlspecialchars($rank['total_achievements']); ?></td>
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
                <button class="btn-pagination">Prev</button>
                <button class="active">1</button>
                <button class="btn-pagination">2</button>
                <button class="btn-pagination">3</button>
                <button class="btn-pagination">Next</button>
            </div>
        </main>
    </div>

    </div>
</body>
