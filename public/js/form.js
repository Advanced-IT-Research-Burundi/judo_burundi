document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('myForm');
    const submitButton = document.getElementById('submitButton');
    const loadingSpinner = document.getElementById('loadingSpinner');

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Disable the submit button and show the loading spinner
        submitButton.disabled = true;
        loadingSpinner.style.display = 'inline-block';

        // Simulate form submission process (e.g., AJAX request)
        setTimeout(function() {
            // Re-enable the submit button and hide the loading spinner
            submitButton.disabled = false;
            loadingSpinner.style.display = 'none';

            // Optionally, you can reset the form or show a success message here
            form.reset();
            alert('Form submitted successfully!');
        }       , 2000); // Simulate a 2-second delay for submission
    });
});