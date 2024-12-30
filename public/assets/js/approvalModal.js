document.addEventListener('DOMContentLoaded', () => {
    // Event delegation for status clicks
    document.addEventListener('click', (e) => {
        // Handle status clicks
        if (e.target.closest('.status')) {
            const statusElement = e.target.closest('.status');
            openAchievementModal(statusElement);
        }

        // Handle close button clicks
        if (e.target.closest('.close-btn')) {
            toggleDetail();
        }

        // Handle filter button clicks
        if (e.target.closest('.filter')) {
            toggleFilter();
        }

        // Handle outside modal clicks
        if (e.target.classList.contains('achievement-detail')) {
            toggleDetail();
        }
    });

    function openAchievementModal(element) {
        const modal = document.getElementById('detail-modal');
        if (!modal || !element) return;

        modal.setAttribute('data-achievement-id', element.dataset.achievementId);

        // Set modal content
        const data = {
            id: element.dataset.achievementId,
            title: element.dataset.title,
            description: element.dataset.description,
            category: element.dataset.category,
            date: element.dataset.date,
            organizer: element.dataset.organizer,
            certificate: element.dataset.certificate,
            documentation: element.dataset.documentation,
            status: element.dataset.status,
            verificationBy: element.dataset.verificationBy,
            verificationAt: element.dataset.verificationAt
        };

        // Populate modal content
        document.getElementById('modal-title').textContent = data.title;
        document.getElementById('modal-description').textContent = data.description;
        document.getElementById('modal-category').textContent = data.category;
        document.getElementById('modal-date').textContent = data.date;
        document.getElementById('modal-organizer').textContent = data.organizer;

        // Handle file displays
        const certificateImg = document.getElementById('modal-certificate');
        const certificateType = element.dataset.certificateType || 'png';
        displayFile(certificateImg, data.certificate, certificateType);

        const documentationImg = document.getElementById('modal-documentation');
        const documentationType = element.dataset.documentationType || 'png';
        displayFile(documentationImg, data.documentation, documentationType);

        const detailActions = document.querySelector('#detail-modal .detail-actions');
        console.log('Detail Actions Element:', detailActions); // Debug log

        if (detailActions) {
            if (data.status === 'Approved') {
                detailActions.innerHTML = `
                    <p class="verification-info">
                        Approved by: ${data.verificationBy || 'System'}<br>
                        on ${data.verificationAt || '-'}
                    </p>`;
            } else if (data.status === 'Rejected') {
                detailActions.innerHTML = `
                    <p class="rejected-info">
                        Rejected by: ${data.verificationBy || 'System'}<br>
                        on ${data.verificationAt || '-'}
                    </p>`;
            } else {
                detailActions.innerHTML = `
                    <button id="reject" type="button" onclick="handleReject()">Reject</button>
                    <button id="approve" type="button" onclick="handleApprove()">Approve</button>`;
            }
        }

        modal.style.display = 'flex';
        modal.classList.add('show');
    }

    function displayFile(element, fileData, fileType) {
        if (!fileData) {
            console.log('No file data provided');
            element.style.display = 'none';
            return;
        }

        try {
            const cleanBase64 = fileData.replace(/\s/g, '');
            const fileExtension = fileType.toLowerCase();

            if (fileExtension === 'pdf') {
                const pdfContainer = document.createElement('embed');
                pdfContainer.src = `data:application/pdf;base64,${cleanBase64}`;
                pdfContainer.type = 'application/pdf';
                pdfContainer.style.width = '100%';
                pdfContainer.style.height = '500px';
                element.parentNode.replaceChild(pdfContainer, element);
            } else {
                const mimeTypeMap = {
                    'jpg': 'jpeg',
                    'jpeg': 'jpeg',
                    'png': 'png'
                };
                const mimeType = mimeTypeMap[fileExtension] || 'png';
                element.src = `data:image/${mimeType};base64,${cleanBase64}`;
                element.style.display = 'block';
            }
        } catch (error) {
            console.error('File display error:', error);
            element.style.display = 'none';
        }
    }

    function toggleDetail() {
        const modal = document.getElementById('detail-modal');
        if (modal) {
            modal.style.display = 'none';
            modal.classList.remove('show');
        }
    }

    function toggleFilter() {
        const filterModal = document.getElementById('filter-modal');
        if (filterModal) {
            const currentDisplay = filterModal.style.display;
            filterModal.style.display = currentDisplay === 'block' ? 'none' : 'flex';
        }
    }

    // Approve Handler
    // Update the approve handler
    window.handleApprove = async function () {
        const modal = document.getElementById('detail-modal');
        const achievementId = modal.getAttribute('data-achievement-id');

        console.log('Approving achievement:', achievementId);

        if (!achievementId) {
            console.error('No achievement ID found');
            return;
        }

        try {
            const response = await fetch(`/api/achievements/approve/${achievementId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });

            console.log('Response status:', response.status);

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            console.log('Response data:', data);

            if (data.success) {
                alert('Achievement approved successfully!');
                toggleDetail();
                location.reload();
            } else {
                throw new Error(data.error || 'Failed to approve achievement');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error approving achievement: ' + error.message);
        }
    };

    // Reject Handler
    // Replace existing reject handler with:
    window.handleReject = async function () {
        const modal = document.getElementById('detail-modal');
        const achievementId = modal.getAttribute('data-achievement-id');

        console.log('Rejecting achievement:', achievementId);

        if (!achievementId) {
            console.error('No achievement ID found');
            return;
        }

        try {
            const response = await fetch(`/api/achievements/reject/${achievementId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });

            console.log('Response status:', response.status);

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            console.log('Response data:', data);

            if (data.success) {
                alert('Achievement rejected successfully!');
                toggleDetail();
                location.reload();
            } else {
                throw new Error(data.error || 'Failed to reject achievement');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error rejecting achievement: ' + error.message);
        }
    };

    // Make functions globally available if needed
    window.openAchievementModal = openAchievementModal;
    window.toggleDetail = toggleDetail;
    window.toggleFilter = toggleFilter;
});
