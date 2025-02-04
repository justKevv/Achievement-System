<head>
    <link rel="stylesheet" href="/assets/css/user.css">
    <script defer src="/assets/js/pagination.js"></script>
    <script defer src="/assets/js/modalAdd.js"></script>
</head>

<body>
    <div class="container">
        <main>
            <div class="content-header">
                <h2>User</h2>
                <div class="actions">
                    <div class="search">
                        <input type="text" placeholder="Search">
                        <button class="search-btn"><img src="../../assets/icons/search.png" alt="Search"></button>
                    </div>
                    <div class="filter" onclick="toggleFilter()">
                        <button class="filter-btn">Filter</button>
                        <img src="../../assets/icons/filter.png" alt="Filter">
                    </div>
                    <button class="add-btn" onclick="toggleDetail()">+ Add User</button>
                </div>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>User Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php
                        $i = 1;
                        ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo $i++ ?></td>
                                <td><?php
                                    $name = isset($user['name']) ? $user['name'] : (isset($user['chairman_name']) ? $user['chairman_name'] : (isset($user['admin_name']) ? $user['admin_name'] : (isset($user['student_name']) ? $user['student_name'] : '')));

                                    echo strlen($name) > 30 ? substr($name, 0, 27) . '...' : $name;
                                    ?></td>
                                <td><?php echo $user['user_email'] ?></td>
                                <td>
                                    <div class="role <?php echo strtolower($user['role_name']) ?>">
                                        <p><?php echo $user['role_name'] ?></p>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-menu">
                                        <div class="btn-actions" onclick="toggleActionMenu(this)">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="6" cy="12" r="2" fill="#42548C" />
                                                <circle cx="12" cy="12" r="2" fill="#42548C" />
                                                <circle cx="18" cy="12" r="2" fill="#42548C" />
                                            </svg>
                                        </div>
                                        <div class="dropdown">
                                            <div onclick="toggleDetail(<?php echo $user['user_id'] ?>)"><span><img src="../../assets/icons/edit.png" alt=""></span>Edit</div>
                                            <div onclick="deleteRow(<?php echo $user['user_id'] ?>)"><span><img src="../../assets/icons/trash.png" alt=""></span>Delete</div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No users found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination">
                <button class="btn-pagination" data-page="prev">Prev</button>
                <?php
                $rowsPerPage = 10;
                $totalRows = count($users);
                $pages = ceil($totalRows / $rowsPerPage);

                // Generate page buttons
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
                            <label for="user-role">User Role</label>
                            <p>Clear</p>
                        </div>
                        <input type="text" id="user-role">
                    </div>
                </div>
                <div class="modal-actions">
                    <button id="reset-btn" type="button" onclick="resetFilterUser()">Reset</button>
                    <button id="apply-btn" type="submit">Apply</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add User Student Modal -->
    <div class="achievement-detail" id="detail-modal">
        <div class="achievement-detail-content">
            <form onsubmit="return false;" id="user-form">
                <input type="hidden" id="user-id" name="user_id">
                <div class="header-detail">
                    <div class="header-left">
                        <h2>Add New User</h2>
                    </div>
                    <div class="header-right">
                        <select id="role-select" name="role" onchange="updateFormFields(this.value)">
                            <option value="">Select Role</option>
                            <option value="student">Student</option>
                            <option value="admin">Admin</option>
                            <option value="chairman">Chairman</option>
                        </select>
                        <button class="close-btn" onclick="window.toggleDetail()">&times;</button>
                    </div>
                </div>
                <div class="detail-content">

                    <!-- Student Fields -->
                    <div id="student-fields" style="display: none">
                        <div class="detail-content">
                            <div class="profile-section">
                                <div class="profile-picture">
                                    <img src="../../assets/images/avatar.png" alt="Profile Picture" id="profile-preview" />
                                    <input type="file" id="profile-upload" accept="image/*" onchange="previewImage(event)" />
                                </div>
                            </div>
                            <div class="right-detail">
                                <div class="detail">
                                    <p>NIM</p>
                                    <input type="text" id="student-nim" name="student_nim" placeholder="Enter NIM">
                                </div>
                                <div class="detail">
                                    <p>Name</p>
                                    <input type="text" id="student-name" name="student_name" placeholder="Enter full name">
                                </div>
                                <div class="detail">
                                    <p>Study Program</p>
                                    <select id="student-study-program" name="student_study_program">
                                        <option value="D4-Informatics Engineering">D4 Informatics Engineering</option>
                                        <option value="D4-Business Information System">D4 Business Information System</option>
                                        <option value="D2-Site Software Development">D2 Site Software Development</option>
                                    </select>
                                </div>
                                <div class="detail">
                                    <p>Class</p>
                                    <input type="text" id="student-class" name="student_class" placeholder="Enter class">
                                </div>
                                <div class="detail">
                                    <p>Gender</p>
                                    <select id="student-gender" name="student_gender">
                                        <option value="M">Male</option>
                                        <option value="F">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="left-detail">
                                <div class="detail">
                                    <p>Date of Birth</p>
                                    <input type="date" id="student-date-of-birth" name="student_date_of_birth">
                                </div>
                                <div class="detail">
                                    <p>Enrollment Date</p>
                                    <input type="date" id="student-enrollment-date" name="student_enrollment_date">
                                </div>
                                <div class="detail">
                                    <p>Address</p>
                                    <input type="text" id="student-address" name="student_address" placeholder="Enter address">
                                </div>
                                <div class="detail">
                                    <p>Phone Number</p>
                                    <input type="text" id="student-phone-number" name="student_phone_number" placeholder="Enter phone number">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Admin Fields -->
                    <div id="admin-fields" style="display: none">
                        <div class="detail-content">
                            <div class="right-detail-admin">
                                <div class="detail">
                                    <p>Admin Name</p>
                                    <input type="text" id="admin-name" name="admin_name" placeholder="Enter admin name">
                                </div>
                            </div>
                            <div class="left-detail-admin">
                                <div class="detail">
                                    <p>NIP</p>
                                    <input type="text" id="admin-nip" name="admin_nip" placeholder="Enter NIP">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chairman Fields -->
                    <div id="chairman-fields" style="display: none">
                        <div class="detail-content">
                            <div class="right-detail-admin">
                                <div class="detail">
                                    <p>Chairman Name</p>
                                    <input type="text" id="chairman-name" name="chairman_name" placeholder="Enter chairman name">
                                </div>
                            </div>
                            <div class="left-detail-admin">
                                <div class="detail">
                                    <p>NIP</p>
                                    <input type="text" id="chairman-nip" name="chairman_nip" placeholder="Enter NIP">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="divider">
                <!-- Common Fields -->
                <div class="detail-content">
                    <div class="left-detail-bottom">
                        <div class="input-field">
                            <p><label for="email">Email</label></p>
                            <input type="email" id="email" name="email" placeholder="Enter email address">
                        </div>
                    </div>
                    <div class="right-detail-bottom">
                        <div class="input-field">
                            <p><label for="password">Password</label></p>
                            <input type="password" id="password" name="password" placeholder="Enter password">
                        </div>
                    </div>
                </div>

                <div class="detail-actions">
                    <button type="button" id="submit" onclick="handleSubmit(event)">Submit</button>
                </div>
            </form>
        </div>
    </div>
</body>
