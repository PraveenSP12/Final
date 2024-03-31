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

    // Clear form inputs
    document.getElementById('medication-name').value = '';
    document.getElementById('medication-time').value = '';

    // Render the updated medication list
    renderMedicationList();
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
            <button onclick="removeMedication(${index})"></button>`;
        medicationList.appendChild(listItem);
    });
}
// Initial rendering of the medication list
renderMedicationList();
