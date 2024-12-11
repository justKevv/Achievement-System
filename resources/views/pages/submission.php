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
              <button class="filter-btn" >Filter</button>
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
            <th>Action</th>
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
                <div class="status pending">
                    <div class="img-status">
                        <img src="/assets/icons/pending.png" alt="">
                    </div>
                    <p>Pending</p>
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
                  <div onclick="editRow()"><span><img src="/assets/icons/edit.png" alt=""></span>Edit</div>
                  <div onclick="deleteRow()"><span><img src="/assets/icons/trash.png" alt=""></span>Delete</div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td>TechFest Hackathon 2024</td>
            <td>International</td>
            <td>University</td>
            <td>2024/09/10</td>
            <td>
                <div class="status rejected">
                    <span class="img-status"><img src="/assets/icons/reject.png" alt=""></span>
                    <p>Rejected</p>
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
                  <div onclick="editRow()"><span><img src="/assets/icons/edit.png" alt=""></span>Edit</div>
                  <div onclick="deleteRow()"><span><img src="/assets/icons/trash.png" alt=""></span>Delete</div>
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

  <!-- Input Achievement Modal -->
  <div class="achievement-detail" id="detail-modal">
    <div class="achievement-detail-content">
        <div class="header-detail">
            <h3>Input Achievement Data</h3>
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
</body>
