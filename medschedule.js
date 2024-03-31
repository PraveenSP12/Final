// Function to add medication
function addMedication() {
    const medicationName = document.getElementById('medication-name').value;
    const medicationTime = document.getElementById('medication-time').value;

    // Validate input
    if (!medicationName || !medicationTime) {
        alert('Please fill out all fields.');
        return;
    }

    // Create medication object
    const newMedication = {
        name: medicationName,
        time: medicationTime,
    };

    // Get existing medications from local storage or create an empty array
    const existingMedications = JSON.parse(localStorage.getItem('medications')) || [];

    // Add the new medication
    existingMedications.push(newMedication);
    

    // Save medications to local storage
    localStorage.setItem('medications', JSON.stringify(existingMedications));

    renderMedicationList();

    // Start checking the time
    checkTime();
}

// Function to check medication time and send email if necessary
function checkTime() {
    const medications = JSON.parse(localStorage.getItem('medications')) || [];

    medications.forEach(medication => {
        const medicationTime = new Date(medication.time);
        const currentTime = new Date();
        if (currentTime >= medicationTime) {
            const photoUploaded = localStorage.getItem('photoUploaded');
            if (!photoUploaded) {
                // Send an AJAX request to the PHP script to send the email
                const xhr = new XMLHttpRequest();
                xhr.open('GET', 'send_email.php', true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            showAlert('Email sent successfully!', 'success');
                        } else {
                            showAlert('Failed to send email.', 'error');
                        }
                    }
                };
                xhr.send();
            }
        }
    });

    // Check the time every minute
const interval = setInterval(checkTime, 60000);

}

// Function to show alert messages
function showAlert(message, type) {
    // Your implementation to show alert messages
}

// Function to render medication list
function renderMedicationList() {
    const medicationList = document.getElementById('medication-items');
    medicationList.innerHTML = ''; // Clear existing list items

    // Retrieve medications from local storage
    const medications = JSON.parse(localStorage.getItem('medications')) || [];

    // Loop through medications and render list items
    medications.forEach((medication, index) => {
        const listItem = document.createElement('li');
        listItem.innerHTML = `<strong>${medication.name}</strong> - ${medication.time}
            <button onclick="removeMedication(${index})">Remove</button>`;
        medicationList.appendChild(listItem);
    });
}

// Function to remove medication
function removeMedication(index) {
    // Retrieve medications from local storage
    const medications = JSON.parse(localStorage.getItem('medications')) || [];

    // Remove the selected medication
    medications.splice(index, 1);

    // Save updated medications to local storage
    localStorage.setItem('medications', JSON.stringify(medications));

    // Render the updated medication list
    renderMedicationList();
}

// Initial rendering of the medication list
renderMedicationList();
