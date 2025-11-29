// Function to validate first name
function validateFirstName() {
    const firstNameInput = document.getElementById('first-name');
    const firstNameValue = firstNameInput.value.trim();

    if (firstNameValue === '') {
        setErrorFor(firstNameInput, 'First name cannot be blank');
        return false;
    } else {
        setSuccessFor(firstNameInput);
        return true;
    }
}

// Function to validate last name
function validateLastName() {
    const lastNameInput = document.getElementById('last-name');
    const lastNameValue = lastNameInput.value.trim();

    if (lastNameValue === '') {
        setErrorFor(lastNameInput, 'Last name cannot be blank');
        return false;
    } else {
        setSuccessFor(lastNameInput);
        return true;
    }
}

// Function to validate email
function validateEmail() {
    const emailInput = document.getElementById('email');
    const emailValue = emailInput.value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (emailValue === '') {
        setErrorFor(emailInput, 'Email cannot be blank');
        return false;
    } else if (!emailRegex.test(emailValue)) {
        setErrorFor(emailInput, 'Email is not valid');
        return false;
    } else {
        setSuccessFor(emailInput);
        return true;
    }
}

// Function to validate phone number
function validatePhoneNumber() {
    const phoneInput = document.getElementById('phone');
    const phoneValue = phoneInput.value.trim();
    const phoneRegex = /^\d{10}$/; // Assuming phone number is 10 digits

    if (phoneValue === '') {
        setErrorFor(phoneInput, 'Phone number cannot be blank');
        return false;
    } else if (!phoneRegex.test(phoneValue)) {
        setErrorFor(phoneInput, 'Phone number is not valid');
        return false;
    } else {
        setSuccessFor(phoneInput);
        return true;
    }
}

// Function to validate username
function validateUsername() {
    const usernameInput = document.getElementById('username');
    const usernameValue = usernameInput.value.trim();

    if (usernameValue === '') {
        setErrorFor(usernameInput, 'Username cannot be blank');
        return false;
    } else {
        setSuccessFor(usernameInput);
        return true;
    }
}

// Function to validate password
function validatePassword() {
    const passwordInput = document.getElementById('password');
    const passwordValue = passwordInput.value.trim();

    if (passwordValue === '') {
        setErrorFor(passwordInput, 'Password cannot be blank');
        return false;
    } else if (passwordValue.length < 6) {
        setErrorFor(passwordInput, 'Password must be at least 6 characters long');
        return false;
    } else {
        setSuccessFor(passwordInput);
        return true;
    }
}

// Function to validate repeat password
function validateRepeatPassword() {
    const repeatPasswordInput = document.getElementById('repeat-password');
    const repeatPasswordValue = repeatPasswordInput.value.trim();
    const passwordInput = document.getElementById('password');
    const passwordValue = passwordInput.value.trim();

    if (repeatPasswordValue === '') {
        setErrorFor(repeatPasswordInput, 'Repeat password cannot be blank');
        return false;
    } else if (repeatPasswordValue !== passwordValue) {
        setErrorFor(repeatPasswordInput, 'Passwords do not match');
        return false;
    } else {
        setSuccessFor(repeatPasswordInput);
        return true;
    }
}

// Function to set error message for input field
function setErrorFor(input, message) {
    const formControl = input.parentElement; // .form-group
    const errorMessage = formControl.querySelector('small');

    errorMessage.innerText = message;

    formControl.className = 'form-group error';
}

// Function to set success style for input field
function setSuccessFor(input) {
    const formControl = input.parentElement; // .form-group
    formControl.className = 'form-group success';
}

// Get form element
const form = document.getElementById('registration-form');

// Add event listener for form submission
form.addEventListener('submit', function(e) {
    e.preventDefault();

    // Validate form fields
    const isFirstNameValid = validateFirstName();
    const isLastNameValid = validateLastName();
    const isEmailValid = validateEmail();
    const isPhoneValid = validatePhoneNumber();
    const isUsernameValid = validateUsername();
    const isPasswordValid = validatePassword();
    const isRepeatPasswordValid = validateRepeatPassword();

    // If all fields are valid, submit form
    if (isFirstNameValid && isLastNameValid && isEmailValid && isPhoneValid && isUsernameValid && isPasswordValid && isRepeatPasswordValid) {
        form.submit();
    }
});
