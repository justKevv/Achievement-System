document.addEventListener('DOMContentLoaded', function() {
    const rowsPerPage = 10;
    const tableRows = document.querySelectorAll('tbody tr');
    const totalRows = tableRows.length;
    const totalPages = Math.ceil(totalRows / rowsPerPage);
    let currentPage = 1;

    function updateRowNumbers(page) {
        const start = (page - 1) * rowsPerPage;
        const visibleRows = document.querySelectorAll('tbody tr:not([style*="display: none"])');
        visibleRows.forEach((row, index) => {
            const numberCell = row.cells[0];
            numberCell.textContent = start + index + 1;
        });
    }

    function showPage(page) {
        tableRows.forEach((row, index) => {
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            row.style.display = (index >= start && index < end) ? '' : 'none';
        });

        updateRowNumbers(page);

        document.querySelectorAll('.pagination button').forEach(btn => {
            btn.classList.remove('active');
            if(btn.dataset.page == page) {
                btn.classList.add('active');
            }
        });

        const prevBtn = document.querySelector('button[data-page="prev"]');
        const nextBtn = document.querySelector('button[data-page="next"]');
        prevBtn.disabled = page === 1;
        nextBtn.disabled = page === totalPages;
    }

    document.querySelector('.pagination').addEventListener('click', (e) => {
        if (e.target.tagName === 'BUTTON') {
            const page = e.target.dataset.page;

            if (page === 'prev' && currentPage > 1) {
                currentPage--;
            } else if (page === 'next' && currentPage < totalPages) {
                currentPage++;
            } else if (page !== 'prev' && page !== 'next') {
                currentPage = parseInt(page);
            }

            showPage(currentPage);
        }
    });

    // Initial page load
    showPage(1);
});
