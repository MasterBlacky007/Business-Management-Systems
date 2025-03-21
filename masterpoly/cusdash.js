function toggleSidebar() {
    document.querySelector(".sidebar").classList.toggle("collapsed");
    document.querySelector(".main-content").classList.toggle("collapsed");
}


let slideIndex = 0;

function showSlides() {
    let slides = document.querySelectorAll(".slide");

    // Hide all slides
    slides.forEach(slide => slide.style.display = "none");

    // Increment slide index
    slideIndex++;
    if (slideIndex > slides.length) {
        slideIndex = 1;
    }

    // Show the current slide
    slides[slideIndex - 1].style.display = "block";

    // Run the function every 3 seconds
    setTimeout(showSlides, 3000);
}

// Initialize Slideshow on Page Load
document.addEventListener("DOMContentLoaded", showSlides);
