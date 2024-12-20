const toggleButton = document.getElementById('toggleButton');
const ajouterLigne = document.getElementById('ajouterLigne');
const exempleLigne = document.getElementById('exempleLigne');
const elements = document.getElementsByClassName('afficheAdmin');
const entrerValeurRows = document.querySelectorAll('.entrerValeur');

function toggleElements(shouldShow) {
    // Toggle visibility of buttons
    ajouterLigne.classList.toggle('d-none', !shouldShow); // Add row button
    exempleLigne.classList.toggle('d-none', !shouldShow); // Example line
    Array.from(elements).forEach(el => el.classList.toggle('d-none', !shouldShow)); // Modify, delete, save buttons

    // Enable or disable editing of inputs
    entrerValeurRows.forEach(row => {
        row.querySelectorAll('td').forEach(td => {
            const input = td.querySelector('input');
            if (input) {
                input.readOnly = !shouldShow; // Enable or disable editing
            }
        });
    });
}

toggleButton.addEventListener('change', function() {
    toggleElements(this.checked);
});

// Add Row Button Action
ajouterLigne.addEventListener('click', function() {
    // Here, you can dynamically add a new row to the table
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td><input type="text" name="column1"></td>
        <td><input type="text" name="column2"></td>
        <td><button class="afficheAdmin d-none" onclick="saveRow(this)">Save</button></td>
        <td><button class="afficheAdmin d-none" onclick="deleteRow(this)">Delete</button></td>
    `;
    document.querySelector('table tbody').appendChild(newRow);
});

// Delete Row Functionality
function deleteRow(button) {
    const row = button.closest('tr');
    row.remove();
}

// Save Row Functionality
function saveRow(button) {
    const row = button.closest('tr');
    const inputs = row.querySelectorAll('input');
    
    // Example saving logic (you can adapt this to save to the server or database)
    inputs.forEach(input => {
        // For now, we just log the values to the console (you can send to the backend)
        console.log(input.value);
    });

    // Hide save button after saving
    button.classList.add('d-none');
    const deleteButton = row.querySelector('button:nth-child(2)');
    deleteButton.classList.add('d-none');
}
