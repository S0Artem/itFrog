document.addEventListener("DOMContentLoaded", function () {
    const sliderContainer = document.querySelector(".slider-container");
    const slides = Array.from(sliderContainer.children);
    const prevBtn = document.querySelector(".prev");
    const nextBtn = document.querySelector(".next");

    let index = 0;
    let totalSlides = slides.length;

    function updateSlider() {
        sliderContainer.style.transition = "transform 0.5s ease-in-out";
        sliderContainer.style.transform = `translateX(-${index * 100}%)`;
    }

    nextBtn.addEventListener("click", () => {
        if (index < totalSlides - 1) {
            index++;
        } else {
            index = 0;
        }
        updateSlider();
    });

    prevBtn.addEventListener("click", () => {
        if (index > 0) {
            index--;
        } else {
            index = totalSlides - 1;
        }
        updateSlider();
    });

    updateSlider();
});




