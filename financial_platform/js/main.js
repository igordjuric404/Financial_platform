$(document).ready(function () {



    $('#personal-button').click((e)=>{
        e.preventDefault();

        let country = $('#country-label').val();
        let address = $('#street-name').val();
        let zipCode = $('#postal-code').val();
        let city = $('#city-town').val();
        let email = $('#email').val();

        $.ajax({
            url: 'php/updateProfile.php',
            type: 'POST',
            data: {
                email: email,
                country: country,
                address: address,
                zipCode: zipCode,
                city: city
            },
            success: function(response){
                if(response === 'ok'){
                    console.log("Updated profile");
                } else {
                    console.log("Error: " + response);
                }
            },
            error: function(){
                console.log("Error with request.");
            }
        });
    });

    $('#login-button').click((e)=>{
        e.preventDefault();

        var email = $('#email').val();
        var password = $('#password').val();

        $.ajax({
            url:'php/signin.php',
            type: 'POST',
            data:{
                email: email,
                password: password
            },
            success: function(response){
                    window.location.href = 'clientportal.php';
            },
            error: function(xhr, status, error) {
                $('#login-error')
                    .text('Invalid username or password')
                    .show();

                console.log('Error: ' + error);
                console.log('Response: ' + xhr.responseText);
            }
        });
    });

    $('#submit-withdrawal').click(function() {
        const coin = $('#coin').val();
        const walletAddress = $('#wallet-address').val();
        const amount = $('#amount').val();

        // Validacija inputa
        if (!coin || !walletAddress || !amount) {
            alert('Please fill in all fields!');
            return;
        }

        // Formatiranje iznosa sa dve decimale
        const formattedAmount = parseFloat(amount).toFixed(2); 

        // Slanje podataka na server putem AJAX POST zahteva
        $.ajax({
            url: 'php/submitWithdrawal.php',
            type: 'POST',
            data: { coin: coin, walletAddress: walletAddress, amount: formattedAmount },
            success: function(response) {
                const data = JSON.parse(response);
                if (data.success) {
                    window.location.reload();
                } else {
                    alert('Failed to submit withdrawal: ' + data.message);
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + error);
            }
        });
    });

    $('.cancel-btn').click(function() {
        const transactionId = $(this).data('transaction-id'); // Dobijamo ID transakcije

        // Potvrda korisnika da želi da otkaže
        if (confirm('Are you sure you want to cancel this withdrawal?')) {
            $.ajax({
                url: 'php/cancelWithdrawal.php',  // PHP fajl koji obrađuje poništavanje
                type: 'POST',
                data: { transaction_id: transactionId },
                success: function(response) {
                    console.log(response);
                    const data = JSON.parse(response);
                    if (data.success) {
                        location.reload();  // Osveži stranicu da se prikaže ažurirani status
                    } else {
                        alert('Error: ' + data.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        }
    });

    // REGEXI
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

    // KLIK NA REGISTER NOW
    $("#register-now-button").click(function (e) {
        e.preventDefault();

        let isValid = true;

        // Očisti stare greške
        $(".error-message").text("");

        // Polja
        let email = $("#email").val().trim();
        let password = $("#password").val().trim();
        let repeatPassword = $("#repeat-password").val().trim();
        let country = $("#country").val();

        // COUNTRY VALIDATION
        if (!country) {
            $("#country").parent().find(".error-message").text("Please select your country.");
            isValid = false;
        }

        // EMAIL VALIDATION
        if (!emailRegex.test(email)) {
            $("#email").next(".error-message").text("Please enter a valid email address.");
            isValid = false;
        }

        // PASSWORD VALIDATION
        if (!passwordRegex.test(password)) {
            $("#password").next(".error-message").text("Password must be at least 8 characters, include letters and numbers.");
            isValid = false;
        }

        // REPEAT PASSWORD VALIDATION
        if (password !== repeatPassword) {
            $("#repeat-password").next(".error-message").text("Passwords do not match.");
            isValid = false;
        }

        // AKO NIJE VALIDNO → STOP
        if (!isValid) return;

        // SVE OK → Prikaži personal details formu
        showPersonalDetailsForm();
    });

    // Regexi za personal details
    const nameRegex = /^[A-Za-z]{2,}$/;
    const dateRegex = /^\d{2}\/\d{2}\/\d{4}$/;
    const phoneRegex = /^[+]?[0-9]{6,}$/;

    // Klik na "Save and Continue"
    $("#save-btn").click(function(e) {
        e.preventDefault();

        let isValid = true;

        // Očisti sve prethodne greške
        $("#personal-details-form .error-message").text("");

        // Uzmi podatke
        let firstName = $("#first-name").val().trim();
        let lastName = $("#last-name").val().trim();
        let dateOfBirth = $("#date-of-birth").val().trim();
        let phone = $("#phone").val().trim();

        // FIRST NAME VALIDATION
        if (!nameRegex.test(firstName)) {
            $("#first-name").next(".error-message").text("First name must contain only letters and be at least 2 characters.");
            isValid = false;
        }

        // LAST NAME VALIDATION
        if (!nameRegex.test(lastName)) {
            $("#last-name").next(".error-message").text("Last name must contain only letters and be at least 2 characters.");
            isValid = false;
        }

        // DATE OF BIRTH VALIDATION
        if (!dateRegex.test(dateOfBirth)) {
            $("#date-of-birth").next(".error-message").text("Please enter a valid date (DD/MM/YYYY).");
            isValid = false;
        }

        // PHONE VALIDATION
        if (!phoneRegex.test(phone)) {
            $("#phone").next(".error-message").text("Phone number must be at least 6 digits.");
            isValid = false;
        }

        // Ako nešto nije OK → STOP
        if (!isValid) return;

        // Ako je sve validno → AJAX
        $.ajax({
            url: 'php/signup.php',
            type: 'POST',
            data: {
                firstName: firstName,
                lastName: lastName,
                dateOfBirth: dateOfBirth,
                phone: phone,
                email: $("#email").val(),
                password: $("#password").val(),
                country: $("#country").val(),
                repeatPassword: $("#repeat-password").val(),
            },
            success: function(response) {
                if (response === 'success') {
                    window.location.href = 'clientportal.php';
                } else {
                    console.log("Server error: " + response);
                }
            },
            error: function(xhr, status, error) {
                console.log("AJAX ERROR: " + error);
                alert("There was an error with the request.");
            }
        });
    });

    function showPersonalDetailsForm() {
        document.getElementById('registration-form').style.display = 'none';  // Sakrij registraciju
        document.getElementById('personal-details-form').style.display = 'block';  // Prikazivanje forme za lične podatke
        document.getElementById('register-now-button').style.display = 'none';  // Sakrij dugme 'Register Now'
        document.getElementById('save-btn').style.display = 'block';  // Sakrij dugme 'Register Now'
    }
});