console.log('navbar.js yuklandi');

document.addEventListener("DOMContentLoaded", () => {
    // === NAVBAR ACTIVE LINK ===
    const sections = document.querySelectorAll("section[id]");
    const navLinks = document.querySelectorAll(".nav-links a");

    function activateLink() {
        let current = "";

        sections.forEach(section => {
            const sectionTop = section.offsetTop - 80; // Fixed header offset
            const sectionHeight = section.offsetHeight;

            if (scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
                current = section.getAttribute("id");
            }
        });

        navLinks.forEach(link => {
            link.classList.remove("active");
            if (link.getAttribute("href") === `#${current}`) {
                link.classList.add("active");
            }
        });
    }

    // window.addEventListener("scroll", activateLink);
    // window.addEventListener("load", activateLink);
});

document.addEventListener("DOMContentLoaded", function() {
    console.log('navbar.js yuklandi'); // TEST

    // USER PROFILE DROPDOWN
    const btn = document.getElementById('userProfileBtn');
    const menu = document.getElementById('profileMenu');

    if (btn && menu) {
        btn.addEventListener("click", function(e) {
            console.log('Dropdown tugmasi bosildi');
            e.stopPropagation();
            menu.classList.toggle("active");
        });

        document.addEventListener("click", function() {
            menu.classList.remove("active");
        });

        menu.addEventListener("click", function(e) {
            e.stopPropagation();
        });
    } else {
        console.log('Dropdown elementlari topilmadi');
    }
});



