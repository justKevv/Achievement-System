<link rel="stylesheet" href="/assets/css/studentdata.css">
<script src="/assets/js/script.js"></script>

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
              <button class="filter-btn" >Filter</button>
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
          <tr>
            <td>1</td>
            <td>23456789</td>
            <td>Alexandra Grace</td>
            <td>D4 Informatics Engineering</td>
            <td>2I</td>
            <td>alexandragrace@gmail.com</td>
          </tr>
          <tr>
            <td>2</td>
            <td>23456789</td>
            <td>Alexandra Grace</td>
            <td>D4 Informatics Engineering</td>
            <td>2I</td>
            <td>alexandragrace@gmail.com</td>
          </tr>
          <tr>
            <td>3</td>
            <td>23456789</td>
            <td>Alexandra Grace</td>
            <td>D4 Informatics Engineering</td>
            <td>2I</td>
            <td>alexandragrace@gmail.com</td>
          </tr>
          <tr>
            <td>4</td>
            <td>23456789</td>
            <td>Alexandra Grace</td>
            <td>D4 Informatics Engineering</td>
            <td>2I</td>
            <td>alexandragrace@gmail.com</td>
          </tr>
          <tr>
            <td>5</td>
            <td>23456789</td>
            <td>Alexandra Grace</td>
            <td>D4 Informatics Engineering</td>
            <td>2I</td>
            <td>alexandragrace@gmail.com</td>
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
</div>
</body>
