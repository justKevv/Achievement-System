function toggleFilter() {
    const filterModal = document.getElementById('filter-modal');
    filterModal.style.display =
      filterModal.style.display === 'flex' ? 'none' : 'flex';
}

function toggleDetail() {
    const filterModal = document.getElementById('detail-modal');
    filterModal.style.display =
      filterModal.style.display === 'flex' ? 'none' : 'flex';
}
  
function toggleActionMenu(button) {
    const dropdown = button.nextElementSibling;
    dropdown.style.display =
      dropdown.style.display === 'block' ? 'none' : 'block';
}
  
function editRow() {
    alert('Edit Row');
}
  
function deleteRow() {
    alert('Delete Row');
}
  
function resetFilter() {
    document.getElementById('study-program').value = '';
    document.getElementById('class').value = '';
}
