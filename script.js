const toggleButton = document.getElementById('theme-toggle');

if (localStorage.getItem('theme') === 'dark') {
    document.body.classList.add('dark-mode');
    toggleButton.checked = true;
}

toggleButton.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');

    if (document.body.classList.contains('dark-mode')) {
        localStorage.setItem('theme', 'dark');
    } else {
        localStorage.setItem('theme', 'light');
    }
});
    let lastScrollTop = 0;
    const floatingDock = document.querySelector('.floating-dock-container');


    
        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) { 
                floatingDock.style.display = 'block'; 
            } else {
                floatingDock.style.display = 'none';
            }
            console.log(window.scrollY)
        });


// Get the dropdown and button elements
const dropdown = document.querySelector('.dropdown');
const button = document.querySelector('.dropdown-button');

// Toggle the dropdown on button click
button.addEventListener('click', function(event) {
    dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
    event.stopPropagation(); // Prevent the click event from bubbling up
});

// Close the dropdown if clicked outside
document.addEventListener('click', function(event) {
    if (!button.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.style.display = 'none';
    }
});

