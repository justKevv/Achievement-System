<link rel="stylesheet" href="/assets/css/studentdata.css">
<script src="/assets/js/pagination.js"></script>
<body>
    <div class="container">
        <main>
            <div class="content-header">
                <h2>Student Data</h2>
                <div class="actions">
                    <div class="search">
                        <input type="text" placeholder="Search">
                        <button class="search-btn"><img src="../../assets/icons/search.png" alt="Search"></button>
                    </div>
                    <div class="filter" onclick="toggleFilter()">
                        <button class="filter-btn">Filter</button>
                        <img src="../../assets/icons/filter.png" alt="Filter">
                    </div>
                </div>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Name</th>
                        <th>Study Program</th>
                        <th>Class</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($chairmanStudents) && is_array($chairmanStudents) && !empty($chairmanStudents)) : ?>
                        <?php foreach ($chairmanStudents as $index => $students) : ?>
                            <tr>
                                <td><?php echo $index + 1 ?? '-' ?></td>
                                <td><?php echo htmlspecialchars($students['student_nim']) ?? '-' ?></td>
                                <td><?php echo htmlspecialchars($students['student_name']) ?? '-' ?></td>
                                <td><?php echo htmlspecialchars($students['student_study_program']) ?? '-' ?></td>
                                <td><?php echo htmlspecialchars($students['student_class']) ?? '-' ?></td>
                                <td><?php echo htmlspecialchars($students['user_email']) ?? '-' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-center">No data available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination">
                <button class="btn-pagination" data-page="prev">Prev</button>
                <?php
                $totalRows = count($chairmanStudents); // Assuming $users is your data array
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
                            <label for="study-program">Study Program</label>
                            <p>Clear</p>
                        </div>
                        <input type="text" id="study-program">
                    </div>
                    <div class="input-field">
                        <div class="label">
                            <label for="class">Class</label>
                            <p>Clear</p>
                        </div>
                        <input type="text" id="class">
                    </div>
                </div>
                <div class="modal-actions">
                    <button id="reset-btn" type="button" onclick="resetFilter()">Reset</button>
                    <button id="apply-btn" type="submit">Apply</button>
                </div>
            </form>
        </div>
    </div>
    </div>
</body>
