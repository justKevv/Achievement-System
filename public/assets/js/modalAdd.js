// modalAdd.js
// Global functions
console.log('modalAdd.js loading started');

window.toggleDetail = async function (userId = null) {
    const modal = document.getElementById('detail-modal');
    const modalContent = modal.querySelector('.achievement-detail-content');
    const body = document.body;
    const headerTitle = modal.querySelector('.header-left h2');
    const form = document.getElementById('user-form');
    const roleSelect = document.getElementById('role-select');

    if (modal.style.display === 'flex') {
        modalContent.classList.remove('show');
        modal.classList.remove('show');

        setTimeout(() => {
            modal.style.display = 'none';
            body.classList.remove('modal-open');
            form.reset(); // Reset form when closing
            roleSelect.value = ''; // Reset role select
        }, 300);

        // Hide all role-specific fields
        const fields = ['student-fields', 'admin-fields', 'chairman-fields'];
        fields.forEach(field => {
            const element = document.getElementById(field);
            if (element) {
                element.style.display = 'none';
                element.classList.remove('active-role');
            }
        });
    } else {
        modal.style.display = 'flex';
        body.classList.add('modal-open');

        if (userId) {
            headerTitle.textContent = 'Edit User';
            document.getElementById('user-id').value = userId;
            await loadUserData(userId);
        } else {
            headerTitle.textContent = 'Add New User';
            document.getElementById('user-id').value = '';
            form.reset();
            roleSelect.value = '';

            // Hide all role-specific fields for new user
            const fields = ['student-fields', 'admin-fields', 'chairman-fields'];
            fields.forEach(field => {
                const element = document.getElementById(field);
                if (element) {
                    element.style.display = 'none';
                    element.classList.remove('active-role');
                }
            });
        }

        void modal.offsetHeight;
        modal.classList.add('show');
        modalContent.classList.add('show');
    }
};
window.toggleFilter = function () {
    const filterModal = document.getElementById('filter-modal');
    if (!filterModal) return;
    filterModal.style.display = filterModal.style.display === 'flex' ? 'none' : 'flex';
};

window.toggleActionMenu = function (button) {
    const dropdown = button.nextElementSibling;
    const allDropdowns = document.querySelectorAll('.dropdown');

    // Close all other dropdowns first
    allDropdowns.forEach(d => {
        if (d !== dropdown) {
            d.style.display = 'none';
        }
    });

    // Toggle the clicked dropdown
    if (dropdown) {
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }
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
window.updateFormFields = function (role) {
    const studentFields = document.getElementById('student-fields');
    const adminFields = document.getElementById('admin-fields');
    const chairmanFields = document.getElementById('chairman-fields');

    // Hide all fields first
    [studentFields, adminFields, chairmanFields].forEach(field => {
        if (field) {
            field.style.display = 'none';
            field.classList.remove('active-role');
        }
    });

    // Show selected form
    let targetField = null;
    switch (role) {
        case 'student': targetField = studentFields; break;
        case 'admin': targetField = adminFields; break;
        case 'chairman': targetField = chairmanFields; break;
    }

    if (targetField) {
        targetField.style.display = 'block'; // Change to block
        void targetField.offsetHeight; // Force reflow
        targetField.classList.add('active-role');
    }
};

async function loadUserData(userId) {
    try {
        console.log('Loading user data for ID:', userId);
        const response = await fetch(`/api/users/get/${userId}`);

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const userData = await response.json();
        console.log('Received user data:', userData);

        // First set the email and role
        document.getElementById('email').value = userData.user_email || '';

        // Determine role from role_id
        let role;
        switch (userData.role_id) {
            case 'S': role = 'student'; break;
            case 'A': role = 'admin'; break;
            case 'C': role = 'chairman'; break;
            default: role = '';
        }

        // Set the role select and trigger the change event
        const roleSelect = document.getElementById('role-select');
        roleSelect.value = role;
        updateFormFields(role);

        // Now populate the specific fields based on role
        switch (role) {
            case 'student':
                document.getElementById('student-nim').value = userData.student_nim || '';
                document.getElementById('student-name').value = userData.name || '';
                document.getElementById('student-study-program').value = userData.student_study_program || '';
                document.getElementById('student-class').value = userData.student_class || '';
                document.getElementById('student-gender').value = userData.student_gender || '';
                document.getElementById('student-date-of-birth').value = userData.student_date_of_birth || '';
                document.getElementById('student-enrollment-date').value = userData.student_enrollment_date || '';
                document.getElementById('student-address').value = userData.student_address || '';
                document.getElementById('student-phone-number').value = userData.student_phone_number || '';
                break;
            case 'admin':
                document.getElementById('admin-name').value = userData.name || '';
                document.getElementById('admin-nip').value = userData.admin_nip || '';
                break;
            case 'chairman':
                document.getElementById('chairman-name').value = userData.name || '';
                document.getElementById('chairman-nip').value = userData.chairman_nip || '';
                break;
        }
    } catch (error) {
        console.error('Error loading user data:', error);
        alert('Error loading user data: ' + error.message);
    }
}

// Form submission handler
window.handleSubmit = async function (e) {
    e.preventDefault();
    console.log('Submit clicked');

    const formData = {};
    const role = document.getElementById('role-select').value;
    const userId = document.getElementById('user-id').value; // Fix: Get userId from hidden input
    const isEdit = userId !== '';

    // Common fields
    formData.role = role;
    formData.email = document.getElementById('email').value;
    if (!isEdit) { // Only include password for new users
        formData.password = document.getElementById('password').value;
    }

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
    } else if (role === 'admin') {
        formData.admin_name = document.getElementById('admin-name').value;
        formData.admin_nip = document.getElementById('admin-nip').value;
    } else if (role === 'chairman') {
        formData.chairman_name = document.getElementById('chairman-name').value;
        formData.chairman_nip = document.getElementById('chairman-nip').value;
    }

    try {
        const url = isEdit ? `/api/users/edit/${userId}` : '/api/users/add';
        console.log('Request URL:', url);
        console.log('Request Data:', formData);

        const response = await fetch(url, {
            method: isEdit ? 'PUT' : 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        });

        if (!response.ok) {
            const text = await response.text();
            console.error('Response Text:', text);
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();
        console.log('Response:', result);

        if (result.success) {
            alert(`User ${isEdit ? 'updated' : 'added'} successfully!`);
            window.toggleDetail();
            window.location.reload();
        } else {
            throw new Error(result.message || `Failed to ${isEdit ? 'update' : 'add'} user`);
        }
    } catch (error) {
        console.error('Error:', error);
        alert(`Error ${isEdit ? 'updating' : 'adding'} user: ` + error.message);
    }
};

window.deleteRow = async function (userId) {
    if (confirm('Are you sure you want to delete this user?')) {
        try {
            const response = await fetch(`/api/users/delete/${userId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();

            if (result.success) {
                alert('User deleted successfully!');
                window.location.reload();
            } else {
                throw new Error(result.message || 'Failed to delete user');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error deleting user: ' + error.message);
        }
    }
};

document.addEventListener('DOMContentLoaded', () => {
    // Form submission setup
    const form = document.getElementById('user-form');
    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            await handleSubmit(e);
        });

        form.querySelectorAll('input').forEach(input => {
            input.addEventListener('keypress', async (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault(); // Prevent modal from closing
                    await handleSubmit(e);
                }
            });
        });

        form.querySelectorAll('select').forEach(select => {
            select.addEventListener('keypress', async (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault(); // Prevent modal from closing
                    await handleSubmit(e);
                }
            });
        });
    }

    const submitBtn = document.getElementById('submit');
    if (submitBtn) {
        submitBtn.addEventListener('click', (e) => {
            e.preventDefault();
            handleSubmit(e);
        });
    };

    if (!event.target.closest('.action-menu')) {
        // Close all dropdowns
        const allDropdowns = document.querySelectorAll('.dropdown');
        allDropdowns.forEach(dropdown => {
            dropdown.style.display = 'none';
        });
    };

    // Modal handling
    const modal = document.getElementById('detail-modal');
    const modalContent = modal.querySelector('.achievement-detail-content');

    // Close on background click
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            window.toggleDetail();
        }
    });

    // Prevent modal content clicks from closing
    modalContent.addEventListener('click', (e) => {
        e.stopPropagation();
    });

    // Close on ESC key
    document.addEventListener('keydown', (e) => {
        const modal = document.getElementById('detail-modal');
        if (e.key === 'Escape' && modal.style.display === 'flex') {
            window.toggleDetail();
        }
    });
});

document.querySelectorAll('.action-menu').forEach(menu => {
    menu.addEventListener('click', function (event) {
        event.stopPropagation();
    });
});
