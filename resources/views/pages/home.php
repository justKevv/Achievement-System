<?php if ($_SESSION['role_id'] == 'A') : ?>
    <link rel="stylesheet" href="/resources/css/adminHome.css">
    <body>
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
                            <h2 id="intern">10</h2>
                            <p>International Achievement</p>
                        </div>
                        <div class="stat-box">
                            <h2 id="national">13</h2>
                            <p>National Achievement</p>
                        </div>
                        <div class="stat-box">
                            <h2 id="regional">8</h2>
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
                                    <th>Points</th>
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
                            <tr>
                                <td>1</td>
                                <td>Alexandra Grace</td>
                                <td>TechFest Hackathon 2024</td>
                                <td>International</td>
                                <td>International</td>
                                <td>2024/09/10</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Alexandra Grace</td>
                                <td>TechFest Hackathon 2024</td>
                                <td>International</td>
                                <td>International</td>
                                <td>2024/09/10</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Alexandra Grace</td>
                                <td>TechFest Hackathon 2024</td>
                                <td>International</td>
                                <td>International</td>
                                <td>2024/09/10</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </body>
<?php elseif ($_SESSION['role_id'] == 'S') : ?>

<?php endif; ?>
