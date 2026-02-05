// Main JavaScript for Car Rental Project

document.addEventListener('DOMContentLoaded', function() {
    // Expand/collapse car details
    document.querySelectorAll('.car-row').forEach(function(row) {
        row.addEventListener('click', function() {
            const carId = row.getAttribute('data-car-id');
            const detailsRow = row.nextElementSibling;
            if (detailsRow.style.display === 'none') {
                // Fetch and show details
                fetchCarDetails(carId, detailsRow);
            } else {
                detailsRow.style.display = 'none';
            }
        });
    });

    // Rent a car
    document.querySelectorAll('.rent-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const carId = btn.getAttribute('data-car-id');
            carAction('rent', carId);
        });
    });

    // Release a car
    document.querySelectorAll('.release-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const carId = btn.getAttribute('data-car-id');
            carAction('release', carId);
        });
    });

    // Remove a car (admin)
    document.querySelectorAll('.remove-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const carId = btn.getAttribute('data-car-id');
            carAction('remove', carId);
        });
    });

    // Add Car form (admin)
    if (document.getElementById('add-car-btn')) {
        document.getElementById('add-car-btn').addEventListener('click', function() {
            const formContainer = document.getElementById('add-car-form-container');
            if (formContainer.style.display === 'none' || formContainer.innerHTML === '') {
                fetch('php/add_car_form.php')
                    .then(response => response.text())
                    .then(html => {
                        formContainer.innerHTML = html;
                        formContainer.style.display = '';
                    });
            } else {
                formContainer.style.display = 'none';
            }
        });
    }
});

function fetchCarDetails(carId, detailsRow) {
    fetch('php/car_actions.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=get_details&car_id=' + encodeURIComponent(carId)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const car = data.car;
            detailsRow.innerHTML = `<td colspan="${detailsRow.cells.length}">
                <div class="car-details">
                    <img src="images/${car.image}" alt="Car photo" class="car-photo">
                    <ul>
                        <li><strong>Manufacturer:</strong> ${car.manufacturer}</li>
                        <li><strong>Brand:</strong> ${car.brand}</li>
                        <li><strong>Model:</strong> ${car.model}</li>
                        <li><strong>Registration Plate:</strong> ${car.registration_plate}</li>
                        <li><strong>Type:</strong> ${car.type}</li>
                        <li><strong>Fuel Type:</strong> ${car.fuel_type}</li>
                        <li><strong>Transmission:</strong> ${car.transmission}</li>
                        <li><strong>Mileage:</strong> ${car.mileage} km</li>
                        <li><strong>Info:</strong> ${car.info}</li>
                    </ul>
                </div>
            </td>`;
            detailsRow.style.display = '';
        }
    });
}

function carAction(action, carId) {
    fetch('php/car_actions.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=' + action + '&car_id=' + encodeURIComponent(carId)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Action failed.');
        }
    });
} 