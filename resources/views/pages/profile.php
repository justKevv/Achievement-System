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

        <?php require_once '../resources/views/components/navbar.html'; ?>

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
                        <li><strong>NIM:</strong> 12345678</li>
                        <li><strong>Name:</strong> Adam Smith</li>
                        <li><strong>Study Program:</strong> D4 Informatics Engineering</li>
                        <li><strong>Class:</strong> 2I</li>
                        <li><strong>Gender:</strong> Male</li>
                    </ul>
                </div>
                <div class="right-profile">
                    <ul>
                        <li><strong>Date of Birth:</strong> 12 March 2005</li>
                        <li><strong>Address:</strong> Jl. Jalan No. 45</li>
                        <li><strong>Enrollment Date:</strong> 2023/08/28</li>
                        <li><strong>Phone Number:</strong> 08565431236</li>
                        <li><strong>Email:</strong> adamsmith@polinema.id</li>
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
                    <tr>
                        <td>1</td>
                        <td>TechFest Hackathon 2024</td>
                        <td>International</td>
                        <td>University</td>
                        <td>2024/09/10</td>
                        <td>
                            <button class="see-details" onclick="toggleDetail()">See details</button>
                        </td>
                    </tr>
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
