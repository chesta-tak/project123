// Function to validate the donation form
function validateForm(event) {
    var name = document.getElementById('name').value;
    var phone = document.getElementById('phone').value;

    if (name.trim() === "" || phone.trim() === "") {
        alert("Name and Phone Number are required!");
        event.preventDefault(); // Prevent form submission
        return false;
    }
    // You can add more validation as needed

    return true;
}

// Add event listener to the form for validation
document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('donationForm');
    form.addEventListener('submit', function (event) {
        if (!validateForm(event)) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });
});
