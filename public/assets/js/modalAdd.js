// modalAdd.js
// Global functions
console.log('modalAdd.js loading started');

window.toggleDetail = function () {
    const modal = document.getElementById('detail-modal');
    if (!modal) return;
    modal.style.display = modal.style.display === 'flex' ? 'none' : 'flex';
};

window.toggleFilter = function () {
    const filterModal = document.getElementById('filter-modal');
    if (!filterModal) return;
    filterModal.style.display = filterModal.style.display === 'flex' ? 'none' : 'flex';
};

window.toggleActionMenu = function (button) {
    const dropdown = button.nextElementSibling;
    if (!dropdown) return;
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
};
window.resetFilter = function () {
    const studyProgram = document.getElementById('study-program');
    const classInput = document.getElementById('class');
    if (studyProgram) studyProgram.value = '';
    if (classInput) classInput.value = '';
};
window.resetFilterApproval = function () {
    const categoryInput = document.getElementById('category');
    const statusInput = document.getElementById('status');
    if (categoryInput) categoryInput.value = '';
    if (statusInput) statusInput.value = '';
};
window.resetFilterUser = function () {
    const userInput = document.getElementById('user-role');
    if (userInput) userInput.value = '';
};


// Form handling
window.updateFormFields = function(role) {
    console.log('Role selected:', role); // Debug

    const studentFields = document.getElementById('student-fields');
    const adminFields = document.getElementById('admin-fields');

    if (!studentFields || !adminFields) {
        console.error('Fields not found'); // Debug
        return;
    }

    if (role === 'student') {
        studentFields.style.display = 'flex';
        adminFields.style.display = 'none';
    } else if (role === 'admin') {
        studentFields.style.display = 'none';
        adminFields.style.display = 'flex';
    } else {
        studentFields.style.display = 'none';
        adminFields.style.display = 'none';
    }
};

// Form submission handler
window.handleSubmit = async function(e) {
    e.preventDefault();
    console.log('Submit clicked');

    const formData = {};
    const role = document.getElementById('role-select').value;

    // Common fields
    formData.role = role;
    formData.email = document.getElementById('email').value;
    formData.password = document.getElementById('password').value;

    // Role-specific fields
    if (role === 'student') {
        formData.student_nim = document.getElementById('student-nim').value;
        formData.student_name = document.getElementById('student-name').value;
        formData.student_study_program = document.getElementById('student-study-program').value;
        formData.student_gender = document.getElementById('student-gender').value;
        formData.student_class = document.getElementById('student-class').value;
        formData.student_date_of_birth = document.getElementById('student-date-of-birth').value;
        formData.student_enrollment_date = document.getElementById('student-enrollment-date').value;
        formData.student_address = document.getElementById('student-address').value;
        formData.student_phone_number = document.getElementById('student-phone-number').value;
    } else {
        formData.admin_name = document.getElementById('admin-name').value;
        formData.admin_nip = document.getElementById('admin-nip').value;
    }

    try {
        const response = await fetch('/api/users/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        });

        const result = await response.json();
        console.log('Response:', result);

        if (result.success) {
            alert('User added successfully!');
            window.toggleDetail();
            window.location.reload();
        } else {
            throw new Error(result.message || 'Failed to add user');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error adding user: ' + error.message);
    }
};

// Update form event listener
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('user-form');
    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            handleSubmit(e);
        });
    }

    const submitBtn = document.getElementById('submit');
    if (submitBtn) {
        submitBtn.addEventListener('click', (e) => {
            e.preventDefault();
            handleSubmit(e);
        });
    }
});
