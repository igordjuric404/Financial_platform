$(document).ready(function () {

    function toggleUserProfileDropdown() {
        document.getElementById("userProfileDropdown").classList.toggle("show");
    }

    function toggleSettingsDropdown() {
        document.getElementById("settingsDropdown").classList.toggle("show");
    }

    function navigateToSupportPage() {
        window.location.href = "support.php"; // Replace with the actual URL of the support page
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
        }
        }
    }
    }


    document.addEventListener("DOMContentLoaded", function() {
        var passwordField = document.getElementById("password");
        var newPasswordField = document.getElementById("new-password");
        var confirmPasswordField = document.getElementById("confirm-password");
        var changeButton = document.getElementById("change-button");

        // Function to check if all fields are populated
        function checkFieldsPopulated() {
            return passwordField.value !== "" && newPasswordField.value !== "" && confirmPasswordField.value !== "";
        }

        // Function to toggle button color based on field values
        function toggleButtonColor() {
            if (checkFieldsPopulated()) {
                changeButton.style.backgroundColor = "#0b5ed7"; // Blue color when all fields are populated
            } else {
                changeButton.style.backgroundColor = "#ccc"; // Grey color when any field is empty
            }
        }

        // Attach event listeners to password fields for input change
        passwordField.addEventListener("input", toggleButtonColor);
        newPasswordField.addEventListener("input", toggleButtonColor);
        confirmPasswordField.addEventListener("input", toggleButtonColor);
    });


    //* Hiding password*//

    function togglePasswordVisibility(fieldId) {
        var passwordField = document.getElementById(fieldId);
        var toggleButton = passwordField.parentElement.querySelector('.toggle-password');

        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleButton.style.backgroundImage = "url('eye-off.png')"; /* Replace 'eye-off.png' with your eye-off icon */
        } else {
            passwordField.type = "password";
            toggleButton.style.backgroundImage = "url('eye.png')"; /* Replace 'eye.png' with your eye icon */
        }
    }


    /*Withdrawal*/
    document.addEventListener('DOMContentLoaded', function() {
        const transferMethodInput = document.getElementById('transfer-method');
        const coinInput = document.getElementById('coin');
        const walletAddressInput = document.getElementById('wallet-address');
        const amountInput = document.getElementById('amount');
        const receivingAmountDisplay = document.getElementById('receiving-amount');
        const submitButton = document.getElementById('submit-withdrawal');

        // Function to check if all fields are filled
        function allFieldsFilled() {
            return transferMethodInput.value.trim() !== '' &&
                coinInput.value.trim() !== '' &&
                walletAddressInput.value.trim() !== '' &&
                amountInput.value.trim() !== '';
        }

        // Function to update receiving amount
        function updateReceivingAmount() {
            if (allFieldsFilled()) {
                const amount = parseFloat(amountInput.value);
                if (!isNaN(amount)) {
                    const coin = coinInput.value;
                    const walletAddress = walletAddressInput.value;
                    receivingAmountDisplay.textContent = `Receiving Amount: ${amount.toLocaleString('en-US', { style: 'currency', currency: 'USD' })} to ${coin} ${walletAddress}`;
                    receivingAmountDisplay.style.display = 'block';
                }
            } else {
                receivingAmountDisplay.style.display = 'none';
            }
        }

        // Listen for changes in all input fields
        transferMethodInput.addEventListener('input', updateReceivingAmount);
        coinInput.addEventListener('input', updateReceivingAmount);
        walletAddressInput.addEventListener('input', updateReceivingAmount);
        amountInput.addEventListener('input', updateReceivingAmount);

        // Handle form submission

    });



    // Function to check if the wallet address is valid for Bitcoin (BTC)
    function isValidBTCAddress(address) {
        // Implement your BTC wallet address validation logic here
        // For example, you can use a regular expression to check the format
        // This is just a placeholder, replace it with your actual validation logic
        const btcAddressRegex = /^[13][a-km-zA-HJ-NP-Z1-9]{25,34}$/;
        return btcAddressRegex.test(address);
    }

    // Function to check if the wallet address is valid for Ethereum (ETH)
    function isValidEthereumAddress(address) {
        return /^0x[0-9a-fA-F]{40}$/.test(address);
    }

    function isValidAddress(address, coin) {
        if (coin === 'BTC') {
            return isValidBitcoinAddress(address);
        } else if (coin === 'ETH' || coin === 'USDT') {
            return isValidEthereumAddress(address);
        }
        // Add support for other coins as needed
        return false;
    }

    // Function to update receiving amount and validate wallet address
    document.addEventListener('DOMContentLoaded', function() {
        const amountInput = document.getElementById('amount');
        const coinSelect = document.getElementById('coin');
        const addressInput = document.getElementById('wallet-address');
        const receivingAmountSpan = document.getElementById('receiving-amount');
        const submitButton = document.getElementById('submit-withdrawal');
        const addressErrorMessage = document.getElementById('address-error');

        // Function to check if BTC, ETH, or USDT address is valid
        function isValidAddress(address, coin) {
            // Add your validation logic here
            // For demonstration purposes, let's assume any address is valid
            return true;
        }

        // Function to update receiving amount display
        function updateReceivingAmount() {
            const amount = parseFloat(amountInput.value);
            const coin = coinSelect.value;
            const address = addressInput.value.trim();

            if (!isNaN(amount) && coin && address) {
                const isValid = isValidAddress(address, coin);
                if (isValid) {
                    receivingAmountSpan.textContent = `Receiving Amount: ${amount.toLocaleString('en-US', { style: 'currency', currency: 'USD' })} to ${coin} Address:${address}`;
                    receivingAmountSpan.style.display = 'block';
                    submitButton.disabled = false;
                    addressErrorMessage.textContent = '';
                } else {
                    receivingAmountSpan.style.display = 'none';
                    submitButton.disabled = true;
                    addressErrorMessage.textContent = 'Invalid address';
                }
            } else {
                receivingAmountSpan.style.display = 'none';
                submitButton.disabled = true;
                addressErrorMessage.textContent = '';
            }
        }

        amountInput.addEventListener('input', updateReceivingAmount);
        coinSelect.addEventListener('change', updateReceivingAmount);
        addressInput.addEventListener('input', updateReceivingAmount);


    });





    $('#coin').on('change', function() {
        const coin = $(this).val();
        const $walletAddressField = $('#wallet-address');

        if (coin === "BTC") {
            $walletAddressField.val(generateBTCAddress());
        } else if (coin === "ETH") {
            $walletAddressField.val(generateETHAddress());
        } else if (coin === "USDT") {
            $walletAddressField.val(generateETHAddress());
        } else {
            $walletAddressField.val('');
        }

        showDepositDetails(coin);
    });


    function generateBTCAddress() {
        return "BTC_ADDRESS";
    }

    function generateETHAddress() {
        return "ETH_ADDRESS";
    }

    function showDepositDetails(coin) {
        document.getElementById("btc-details").style.display = "none";
        document.getElementById("eth-details").style.display = "none";
        document.getElementById("usdt-details").style.display = "none";

        if (coin === "BTC") {
            document.getElementById("btc-details").style.display = "block";
        } else if (coin === "ETH") {
            document.getElementById("eth-details").style.display = "block";
        } else if (coin === "USDT") {
            document.getElementById("usdt-details").style.display = "block";
        }
    }

    function copyDepositAddress() {
        var walletAddressField = document.getElementById("wallet-address");
        walletAddressField.select();
        document.execCommand("copy");
    }

    window.addEventListener('resize', function(){
        addRequiredClass();
    })


    function addRequiredClass() {
        const width = document.documentElement.clientWidth;
        if (width < 860) {
            document.body.classList.add('mobile');
        } else {
            document.body.classList.remove('mobile');
        }
    }


    let hamburger = document.querySelector('.hamburger')
    let mobileNav = document.querySelector('.nav-list')

    let bars = document.querySelectorAll('.hamburger span')

    let isActive = false

    hamburger.addEventListener('click', function() {
        mobileNav.classList.toggle('open')
        if(!isActive) {
            bars[0].style.transform = 'rotate(45deg)'
            bars[1].style.opacity = '0'
            bars[2].style.transform = 'rotate(-45deg)'
            isActive = true
        } else {
            bars[0].style.transform = 'rotate(0deg)'
            bars[1].style.opacity = '1'
            bars[2].style.transform = 'rotate(0deg)'
            isActive = false
        }
        

    })

    $('#confirm-deposit').on('click', function() {
        console.log("Clicked");

        const coin = $('#coin').val();
        const amount = parseFloat($('#wallet-address').val()) || 0;

        const minDeposits = {
            'BTC': 0.001,
            'ETH': 0.01,
            'USDT': 10
        };

        $('.deposit-error').remove();

        if (!minDeposits[coin]) {
            alert("Please select a valid coin");
            return;
        }

        if (amount < minDeposits[coin]) {
            const errorEl = $('<p>')
                .addClass('deposit-error')
                .css('color', 'red')
                .text(`Minimum deposit for ${coin} is: ${minDeposits[coin]}`);
            $('#wallet-address').parent().append(errorEl);
            return;
        }

        $.ajax({
            url: 'php/requestDeposit.php',
            method: 'POST',
            data: { coin: coin, amount: amount },
            success: function(response) {
                const data = (typeof response === "string") ? JSON.parse(response) : response;
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert("Došlo je do greške prilikom slanja depozita.");
            }
        });
    });

    $(".submit-buttons button").on("click", function(e) {
        e.preventDefault();
        $("#password-errors").text("");

        const currentPassword = $.trim($("#password").val());
        const newPassword = $.trim($("#new-password").val());
        const confirmPassword = $.trim($("#confirm-password").val());

        let errors = [];

        if (!currentPassword || !newPassword || !confirmPassword) {
            errors.push("Please fill in all fields.");
        }

        if (newPassword !== confirmPassword) {
            errors.push("New password and confirm password do not match.");
        }

        if (errors.length > 0) {
            $("#password-errors").html(errors.join("<br>"));
            return;
        }

        // Slanje AJAX POST zahteva
        $.ajax({
            url: "php/updatePassword.php",
            type: "POST",
            data: {
                currentPassword: currentPassword,
                newPassword: newPassword
            },
            success: function(response) {
                if (response === "success") {
                    $("#password-errors").css("color", "green").text("Password updated successfully!");
                    $("#password-form")[0].reset();
                } else {
                    $("#password-errors").css("color", "red").text(response);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
                $("#password-errors").css("color", "red").text("An error occurred. Please try again.");
            }
        });
    });


});

function addRequiredClass() {
    const width = document.documentElement.clientWidth;
    if (width < 860) {
        document.body.classList.add('mobile');
    } else {
        document.body.classList.remove('mobile');
    }
}

document.addEventListener('DOMContentLoaded', addRequiredClass);
window.addEventListener('resize', addRequiredClass);
