// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        const targetId = this.getAttribute('href').substring(1);
        const target = document.getElementById(targetId);

        if (target) {
            target.scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
});

// Highlight active section in navigation menu
const sections = document.querySelectorAll('section');

window.addEventListener('scroll', () => {
    let current = '';

    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (pageYOffset >= sectionTop - sectionHeight / 3) {
            current = section.getAttribute('id');
        }
    });

    document.querySelectorAll('nav ul li a').forEach(a => {
        a.classList.remove('active');
        if (a.getAttribute('href').includes(current)) {
            a.classList.add('active');
        }
    });
});

// Scroll to top button
const scrollToTopButton = document.getElementById('scrollToTopButton');

if (scrollToTopButton) {
    window.addEventListener('scroll', () => {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            scrollToTopButton.style.display = 'block';
        } else {
            scrollToTopButton.style.display = 'none';
        }
    });

    scrollToTopButton.addEventListener('click', () => {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    });
}


/*Date of Birth*/

function changePlaceholder(input) {
    input.placeholder = "DD/MM/YYYY";
}

function restorePlaceholder(input) {
    input.placeholder = "Date of Birth";
}

/*Dropdown button header*/



document.addEventListener("DOMContentLoaded", function() {
    const dropdownBtns = document.querySelectorAll('.dropdown-btn');
    dropdownBtns.forEach(btn => {
        btn.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default link behavior
            const dropdownMenu = this.querySelector('.dropdown-menu');
            // Toggle the 'show' class to display or hide the dropdown menu
            dropdownMenu.classList.toggle('show');
            // Close other dropdown menus when one is opened
            dropdownBtns.forEach(otherBtn => {
                if (otherBtn !== btn) {
                    otherBtn.querySelector('.dropdown-menu').classList.remove('show');
                }
            });
        });
    });

    // Close dropdown menus when clicking outside of them
    window.addEventListener('click', function(event) {
        dropdownBtns.forEach(btn => {
            if (!btn.contains(event.target)) {
                btn.querySelector('.dropdown-menu').classList.remove('show');
            }
        });
    });
});

function autoFormatDate(input) {
    let value = input.value.replace(/\D/g, ''); // Remove non-numeric characters
    if (value.length > 2 && value.length < 5) {
        value = value.replace(/(\d{2})(\d{2})/, '$1/$2'); // Add "/" after DD
    } else if (value.length >= 5) {
        value = value.replace(/(\d{2})(\d{2})(\d{4})/, '$1/$2/$3'); // Add "/" after MM
    }
    input.value = value;
}

function validateDate(input) {
    let value = input.value;
    // Implement your validation logic here
    // For example, you can check if the entered date is in a valid format
}