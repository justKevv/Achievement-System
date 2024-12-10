// Add this to a new file: assets/js/pagination.js
document.addEventListener('DOMContentLoaded', function() {
    const rowsPerPage = 10;
    const table = document.querySelector('table');
    const rows = table.querySelectorAll('tbody tr');
    const pageCount = Math.ceil(rows.length / rowsPerPage);
    const paginationDiv = document.querySelector('.pagination');

    // Initialize buttons with event listeners
    const buttons = paginationDiv.querySelectorAll('button');
    let currentPage = 1;

    function showPage(pageNum) {
        const start = (pageNum - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        rows.forEach((row, index) => {
            row.style.display = (index >= start && index < end) ? '' : 'none';
        });

        // Update active button
        buttons.forEach(btn => {
            if (btn.textContent === pageNum.toString()) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });
    }

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            if (this.textContent === 'Prev') {
                if (currentPage > 1) currentPage--;
            } else if (this.textContent === 'Next') {
                if (currentPage < pageCount) currentPage++;
            } else {
                currentPage = parseInt(this.textContent);
            }
            showPage(currentPage);
        });
    });

    // Show first page initially
    showPage(1);
});
