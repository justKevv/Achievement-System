document.addEventListener('DOMContentLoaded', () => {
    function openViewModal(element) {
        const modal = document.getElementById('view-modal');
        if (!modal || !element) return;

        modal.setAttribute('data-achievement-id', element.dataset.achievementId);
        console.log('Setting achievement ID:', element.dataset.achievementId);

        const data = {
            id: element.dataset.achievementId,
            title: element.dataset.title,
            description: element.dataset.description,
            category: element.dataset.category,
            date: element.dataset.date,
            organizer: element.dataset.organizer,
            certificate: element.dataset.certificate,
            documentation: element.dataset.documentation
        };

        document.getElementById('view-title').textContent = data.title;
        document.getElementById('view-description').textContent = data.description;
        document.getElementById('view-category').textContent = data.category;
        document.getElementById('view-date').textContent = data.date;
        document.getElementById('view-organizer').textContent = data.organizer;

        const certificateImg = document.getElementById('view-certificate');
        const certificateType = element.dataset.certificateType || 'png';
        displayFile(certificateImg, data.certificate, certificateType);

        const documentationImg = document.getElementById('view-documentation');
        const documentationType = element.dataset.documentationType || 'png';
        displayFile(documentationImg, data.documentation, documentationType);

        const statusSubmit = element.dataset.status;
        const verificationInfo = document.querySelector('.detail-status');

        if (statusSubmit === 'Approved') {
            verificationInfo.innerHTML = `
            <p class="verification-info">
                Approved by: ${element.dataset.verificationBy}<br>
                on ${element.dataset.verificationAt}
            </p>`;
        } else if (statusSubmit === 'Pending') {
            verificationInfo.innerHTML = '<p class="pending-info">Waiting for verification</p>';
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

    function toggleViewModal() {
        const modal = document.getElementById('view-modal');
        if (modal) {
            modal.style.display = 'none';
            modal.classList.remove('show');
        }
    }

    window.openViewModal = openViewModal;
    window.toggleViewModal = toggleViewModal;
});
