<?php if ($_SESSION['role_id'] == 'A') : ?>
    <link rel="stylesheet" href="/assets/css/adminHome.css">
    <div class="home-page">
        <div class="content">
            <div class="left-dashboard">
                <section class="welcome-section">
                    <div class="text">
                        <h1>Welcome to SARS!</h1>
                        <p>SARS is a platform for documenting and managing the achievements of students at the State Polytechnic of Malang, specifically in the Information Technology department.</p>
                    </div>
                    <div class="image">
                        <img src="/assets/images/success.png" alt="Trophy" style="width: 200px;">
                    </div>
                </section>
                <section class="stats-section">
                    <div class="stat-box">
                        <h2 id="intern"><?php echo $stats['intern'] ?? 0 ?></h2>
                        <p>International Achievement</p>
                    </div>
                    <div class="stat-box">
                        <h2 id="national"><?php echo $stats['national'] ?? 0 ?></h2>
                        <p>National Achievement</p>
                    </div>
                    <div class="stat-box">
                        <h2 id="regional"><?php echo $stats['regional'] ?? 0 ?></h2>
                        <p>Regional Achievement</p>
                    </div>
                </section>
            </div>
            <div class="right-dashboard">
                <div class="rankings">
                    <h2>Rank</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Name</th>
                                <th><img src="/assets/images/medal.png" alt="Medal" style="width: 12px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Alexandra Grace</td>
                                <td>7</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Nathaniel James</td>
                                <td>6</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Nathaniel James</td>
                                <td>6</td>
                            </tr>
                            <td>4</td>
                            <td>Anindya</td>
                            <td>6</td>
                            </tr>
                            <td>5</td>
                            <td>Nathaniel James</td>
                            <td>6</td>
                            </tr>
                            <td>6</td>
                            <td>Nathaniel James</td>
                            <td>1</td>
                            </tr>
                            <td></td>
                            <td>See all</td>
                            <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <section class="tables">
            <div class="recent-achievements">
                <h2>Recent Achievements</h2>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Competition Title</th>
                            <th>Category</th>
                            <th>Organizer</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($adminRecent) && is_array($adminRecent) && !empty($adminRecent)) : ?>
                            <?php foreach ($adminRecent as $index => $achievement) : ?>
                                <tr>
                                    <td><?php echo $index + 1 ?? '-' ?></td>
                                    <td><?php echo htmlspecialchars($achievement['student_name']) ?? '-' ?></td>
                                    <td><?php echo htmlspecialchars($achievement['achievement_title']) ?? '-' ?></td>
                                    <td><?php echo htmlspecialchars($achievement['achievement_category']) ?? '-' ?></td>
                                    <td><?php echo htmlspecialchars($achievement['achievement_organizer']) ?? '-' ?></td>
                                    <td><?php echo date('Y/m/d', strtotime($achievement['achievement_date'])) ?? '-' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="text-center">No data available</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
<?php elseif ($_SESSION['role_id'] == 'S') : ?>
    <link rel="stylesheet" href="/assets/css/s_home.css">
    <div class="home-page">
        <div class="content">
            <div class="left-dashboard">
                <section class="welcome-section">
                    <div class="text">
                        <h1>Welcome to SARS!</h1>
                        <p>SARS is a platform for documenting and managing the achievements of
                            students at the State Polytechnic of Malang, specifically in the Information Technology department.</p>
                    </div>
                    <div class="welcome-image">
                        <img src="/assets/images/success.png" alt="Trophy" style="width: 200px;">
                    </div>
                </section>
                <section class="stats-section">
                    <div class="stat-box">
                        <h2 id="intern"><?php echo $stats['intern'] ?? 0 ?></h2>
                        <p>International Achievement</p>
                    </div>
                    <div class="stat-box">
                        <h2 id="national"><?php echo $stats['national'] ?? 0 ?></h2>
                        <p>National Achievement</p>
                    </div>
                    <div class="stat-box">
                        <h2 id="regional"><?php echo $stats['regional'] ?? 0 ?></h2>
                        <p>Regional Achievement</p>
                    </div>
                </section>
                <section class="tables">
                    <div class="recent-achievements">
                        <h2>Recent Achievements</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Competition Title</th>
                                    <th>Category</th>
                                    <th>Organizer</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($recentStudent) && is_array($recentStudent) && !empty($recentStudent)) : ?>
                                    <?php foreach ($recentStudent as $index => $achievement) : ?>
                                        <tr>
                                            <td><?php echo $index + 1 ?? '-' ?></td>
                                            <td><?php echo htmlspecialchars($achievement['achievement_title']) ?? '-' ?></td>
                                            <td><?php echo htmlspecialchars($achievement['achievement_category']) ?? '-' ?></td>
                                            <td><?php echo htmlspecialchars($achievement['achievement_organizer']) ?? '-' ?></td>
                                            <td><?php echo date('Y/m/d', strtotime($achievement['achievement_date'])) ?? '-' ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No data available</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
            <div class="right-dashboard">
                <section class="user-avatar">
                    <img src="/assets/images/avatar.png" alt="Avatar">
                    <h2><?php echo isset($student['student_name']) ? htmlspecialchars($student['student_name']) : 'Student Name'; ?></h2>
                    <p id="major"><?php echo $student['student_study_program'] ?></p>
                    <div class="stats">
                        <div class="detail-stats1">
                            <p>Achievement</p>
                            <p><?php echo $total['total'] ?></p>
                        </div>
                        <div class="detail-stats">
                            <p>Current Rank</p>
                            <p><?php echo $currRank = ($currentRank['total_achievements'] > 0) ? $currentRank['rank'] : "-"; ?></p>
                        </div>
                    </div>
                    <a href="/profile"><button>My Profile</button></a>
                </section>
                <div class="rankings">
                    <h2>Top 3</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Name</th>
                                <th><img src="/assets/images/medal.png" alt="Medal" style="width: 12px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($ranking) && is_array($ranking) && !empty($ranking)) : ?>
                                <?php foreach ($ranking as $rank) : ?>
                                    <?php if (isset($rank['total_achievements']) && $rank['total_achievements'] > 0) : ?>
                                        <tr>
                                            <td><?php echo $rank['rank']; ?></td>
                                            <td><?php echo htmlspecialchars($rank['student_name']); ?></td>
                                            <td><?php echo $rank['total_achievements']; ?></td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="3" class="text-center">No data available</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php elseif ($_SESSION['role_id'] == 'C') : ?>
    <link rel="stylesheet" href="/assets/css/kajurHome.css">

    <body>
        <div class="content">
            <div class="left-dashboard">
                <section class="welcome-section">
                    <div class="text">
                        <h1>Welcome Chairman</h1>
                        <p>SARS is a platform for documenting and managing the achievements of students at the State Polytechnic of Malang, specifically in the Information Technology department.</p>
                    </div>
                    <div class="image">
                        <img src="/assets/images/success.png" alt="Trophy" style="width: 200px;">
                    </div>
                </section>
                <section class="stats-section">
                    <div class="stat-box">
                        <h2 id="intern"><?php echo $stats['intern'] ?? 0 ?></h2>
                        <p>International Achievement</p>
                    </div>
                    <div class="stat-box">
                        <h2 id="national"><?php echo $stats['national'] ?? 0 ?></h2>
                        <p>National Achievement</p>
                    </div>
                    <div class="stat-box">
                        <h2 id="regional"><?php echo $stats['regional'] ?? 0 ?></h2>
                        <p>Regional Achievement</p>
                    </div>
                </section>
            </div>
            <div class="right-dashboard">
                <div class="rankings">
                    <h2>Rank</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Name</th>
                                <th><img src="/assets/images/medal.png" alt="Medal" style="width: 12px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($rankChair) && is_array($rankChair) && !empty($rankChair)) : ?>
                                <?php foreach ($rankChair as $rank) : ?>
                                    <?php if (isset($rank['total_achievements']) && $rank['total_achievements'] > 0) : ?>
                                        <tr>
                                            <td><?php echo $rank['rank']; ?></td>
                                            <td><?php echo htmlspecialchars($rank['student_name']); ?></td>
                                            <td><?php echo $rank['total_achievements']; ?></td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <?php if (count($rankChair) > 6): ?>
                                    <tr>
                                        <td></td>
                                        <td>See all</td>
                                        <td></td>
                                    </tr>
                                <?php endif; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="3" class="text-center">No data available</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <section class="tables">
            <div class="recent-achievements">
                <h2>Recent Achievements</h2>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Competition Title</th>
                            <th>Category</th>
                            <th>Organizer</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($chairmanRecent) && is_array($chairmanRecent) && !empty($chairmanRecent)) : ?>
                            <?php foreach ($chairmanRecent as $index => $achievement) : ?>
                                <tr>
                                    <td><?php echo $index + 1 ?? '-' ?></td>
                                    <td><?php echo htmlspecialchars($achievement['student_name']) ?? '-' ?></td>
                                    <td><?php echo htmlspecialchars($achievement['achievement_title']) ?? '-' ?></td>
                                    <td><?php echo htmlspecialchars($achievement['achievement_category']) ?? '-' ?></td>
                                    <td><?php echo htmlspecialchars($achievement['achievement_organizer']) ?? '-' ?></td>
                                    <td><?php echo date('Y/m/d', strtotime($achievement['achievement_date'])) ?? '-' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="text-center">No data available</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </body>
<?php endif; ?>
