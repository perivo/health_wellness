 
// assets/js/main.js

document.addEventListener('DOMContentLoaded', () => {
    console.log("JavaScript loaded!");

    // Example of form validation on the register page
    const registerForm = document.querySelector('form'); // Update selector if needed
    if (registerForm) {
        registerForm.addEventListener('submit', (e) => {
            const password = registerForm.querySelector('input[name="password"]').value;
            const confirmPassword = registerForm.querySelector('input[name="confirm_password"]').value;

            if (password !== confirmPassword) {
                e.preventDefault();
                alert("Passwords do not match!");
            }
        });
    }

    // Example of fetching yoga data and displaying it dynamically
    fetch('api/fetch_yoga.php')
        .then(response => response.json())
        .then(data => {
            const yogaContainer = document.querySelector('#yoga-exercises'); // Ensure this element exists in your HTML
            data.forEach(exercise => {
                const card = document.createElement('div');
                card.className = 'card';
                card.innerHTML = `<h4>${exercise.name}</h4><p>${exercise.description}</p>`;
                yogaContainer.appendChild(card);
            });
        })
        .catch(error => console.error('Error fetching yoga data:', error));
});
