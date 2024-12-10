<link rel="stylesheet" href="assets/css/user.css">

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
              <button class="filter-btn" >Filter</button>
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
          <tr>
            <td>1</td>
            <td>Alexandra Grace</td>
            <td>alexandragrace@gmail.com</td>
            <td>
                <div class="role admin">
                    <p>Admin</p>
                </div>
            </td>
            <td>
              <div class="action-menu">
                <div class="btn-actions" onclick="toggleActionMenu(this)">
                    <span>.</span>
                    <span>.</span>
                    <span>.</span>
                </div>
                <div class="dropdown">
                  <div onclick="toggleDetail()"><span><img src="../../assets/icons/edit.png" alt=""></span>Edit</div>
                  <div onclick="deleteRow()"><span><img src="../../assets/icons/trash.png" alt=""></span>Delete</div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td>Alexandra Grace</td>
            <td>alexandragrace@gmail.com</td>
            <td>
                <div class="role student">
                    <p>Student</p>
                </div>
            </td>
            <td>
              <div class="action-menu">
                <div class="btn-actions" onclick="toggleActionMenu(this)">
                    <span>.</span>
                    <span>.</span>
                    <span>.</span>
                </div>
                <div class="dropdown">
                  <div onclick="editRow()"><span><img src="img/edit-2.png" alt=""></span>Edit</div>
                  <div onclick="deleteRow()"><span><img src="img/trash.png" alt=""></span>Delete</div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>3</td>
            <td>Alexandra Grace</td>
            <td>alexandragrace@gmail.com</td>
            <td>
              <div class="role chairman">
                  <p>Chairman</p>
              </div>
            </td>
            <td>
              <div class="action-menu">
                <div class="btn-actions" onclick="toggleActionMenu(this)">
                    <span>.</span>
                    <span>.</span>
                    <span>.</span>
                </div>
                <div class="dropdown">
                  <div onclick="editRow()"><span><img src="img/edit-2.png" alt=""></span>Edit</div>
                  <div onclick="deleteRow()"><span><img src="img/trash.png" alt=""></span>Delete</div>
                </div>
              </div>
            </td>
          </tr>
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

  <!-- Add User Student Modal -->
  <div class="achievement-detail" id="detail-modal">
    <div class="achievement-detail-content">
        <div class="header-detail">
            <h3>Add Student</h3>
            <button class="close-btn" onclick="toggleDetail()">✖</button>
        </div>
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
                    <input type="text" value="">
                </div>
                <div class="detail">
                    <p>Name</p>
                    <input type="text" value="">
                </div>
                <div class="detail">
                  <p>Study Program</p>
                  <select>
                    <option value="regional">D4 Informatics Engineering</option>
                    <option value="national">D4 Business Information System</option>
                    <option value="international">D2 Site Software Development</option>
                </select>
              </div>
                <div class="detail">
                    <p>Class</p>
                    <input type="text" value="">
                </div>
                <div class="detail">
                    <p>Date of Birth</p>
                    <input type="date" value="">
                </div>
            </div>
            <div class="left-detail">
                <div class="detail">
                    <p>Address</p>
                    <input type="text" value="">
                </div>
                <div class="detail">
                    <p>Enrollment Date</p>
                    <input type="date" value="">
                </div>
                <div class="detail">
                    <p>Phone Number</p>
                    <input type="text" value="">
                </div>
                <div class="detail">
                    <p>Gender</p>
                    <input type="text" value="">
                </div>
            </div>
        </div>
        <!-- Divider Line -->
        <hr class="divider">
        <!-- Email and Password Section -->
        <div class="detail-content">
            <div class="left-detail-bottom">
            <div class="input-field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email">
            </div>
            </div>
            <div class="right-detail-bottom">
            <div class="input-field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
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
