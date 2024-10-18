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



