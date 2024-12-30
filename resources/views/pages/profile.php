<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="/assets/css/profile.css">

</head>

<body>
    <div class="container">

        <?php require_once '../resources/views/components/navbar.php'; ?>

        <main>
            <div class="content-header-profile">
                <h2>Profile</h2>
            </div>
            <div class="profile-container">
                <div class="left-profile">
                    <img src="../../assets/images/avatar.png" alt="Profile Picture" class="profile-image" />
                </div>
                <div class="center-profile">
                    <ul>
                        <li><strong>NIM:</strong> <?php echo $studentProfile['student_nim'] ?></li>
                        <li><strong>Name:</strong> <?php echo $studentProfile['student_name'] ?></li>
                        <li><strong>Study Program:</strong> <?php echo $studentProfile['student_study_program'] ?></li>
                        <li><strong>Class:</strong> <?php echo $studentProfile['student_class'] ?></li>
                        <li><strong>Gender:</strong> <?php echo ($studentProfile['student_gender'] === 'M') ? "Male" : "Female" ?></li>
                    </ul>
                </div>
                <div class="right-profile">
                    <ul>
                        <li><strong>Date of Birth:</strong> <?php echo date('d M Y', strtotime($studentProfile['student_date_of_birth'])) ?></li>
                        <li><strong>Address:</strong> <?php echo $studentProfile['student_address'] ?></li>
                        <li><strong>Enrollment Date:</strong> <?php echo date('Y/m/d', strtotime($studentProfile['student_date_of_birth'])) ?></li>
                        <li><strong>Phone Number:</strong> <?php echo $studentProfile['student_phone_number'] ?></li>
                        <li><strong>Email:</strong> <?php echo $studentProfile['user_email'] ?></li>
                    </ul>
                </div>
        </main>

        <main>
            <div class="content-header">
                <h2>Achievement</h2>
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
                        <th>Competition Title</th>
                        <th>Category</th>
                        <th>Organizer</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($achievements) && !empty($achievements)): ?>
                        <?php foreach ($achievements as $index => $achievement): ?>
                            <tr>
                                <td><?php echo $index + 1 ?></td>
                                <td><?php echo htmlspecialchars($achievement['achievement_title']) ?></td>
                                <td><?php echo htmlspecialchars($achievement['achievement_category']) ?></td>
                                <td><?php echo htmlspecialchars($achievement['achievement_organizer']) ?></td>
                                <td><?php echo date('Y/m/d', strtotime($achievement['achievement_date'])) ?></td>
                                <td>
                                    <button class="see-details" onclick="toggleDetail('<?php echo $achievement['achievement_id'] ?>')">
                                        See details
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No achievements found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
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

    <!-- See Details Modal -->
    <div class="achievement-detail" id="detail-modal">
        <div class="achievement-detail-content">
            <div class="header-detail">
                <h3>Achievement Details</h3>
                <button class="close-btn" onclick="toggleDetail()">✖</button>
            </div>
            <div class="detail-content">
                <div class="right-detail">
                    <div class="detail">
                        <p>Competition Title</p>
                        <input type="text" value="">
                    </div>
                    <div class="detail">
                        <p>Description</p>
                        <input type="text" value="">
                    </div>
                    <div class="detail">
                        <p>Category</p>
                        <select>
                            <option value="regional">Regional</option>
                            <option value="national">National</option>
                            <option value="international">International</option>
                        </select>
                    </div>
                    <div class="detail">
                        <p>Date</p>
                        <input type="date" value="">
                    </div>
                </div>
                <div class="left-detail">
                    <div class="detail">
                        <p>Organizer</p>
                        <input type="text" value="">
                    </div>
                    <div class="detail">
                        <p>Certificate</p>
                        <input type="file" id="certificate" name="certificate">
                        <span>Max size 5Mb</span>
                    </div>
                    <div class="detail">
                        <p>Activity Documentation</p>
                        <input type="file" id="activity-documentation" name="activity-documentation">
                        <span>Max size 5Mb</span>
                    </div>
                </div>
            </div>
            <div class="detail-actions">
                <button id="submit">Submit</button>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>
