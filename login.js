// Select the buttons and container
const signupBtn = document.getElementById("signup-btn");
const signinBtn = document.getElementById("signin-btn");
const mainContainer = document.querySelector(".container");

// Event listener for the signup button
signupBtn.addEventListener("click", (event) => {
    event.preventDefault(); // Prevent default link behavior
    mainContainer.classList.toggle("change");
});

// Event listener for the signin button
signinBtn.addEventListener("click", () => {
    mainContainer.classList.toggle("change");
});