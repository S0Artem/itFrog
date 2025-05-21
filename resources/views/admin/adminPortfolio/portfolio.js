import TomSelect from "tom-select";
import "tom-select/dist/css/tom-select.css";

// Инициализация
document.querySelectorAll('.form-select').forEach(select => {
    const tom = new TomSelect(select, {
        valueField: 'id',
        labelField: 'label',
        searchField: 'label',
        load: function(query, callback) {
            const url = select.dataset.url + '?q=' + encodeURIComponent(query);
            fetch(url)
                .then(response => response.json())
                .then(json => callback(json))
                .catch(() => callback());
        },
        placeholder: 'Выберите ребёнка...',
    });

    // Установить значение вручную, если data-selected-id и data-selected-label заданы
    const selectedId = select.dataset.selectedId;
    const selectedLabel = select.dataset.selectedLabel;

    if (selectedId && selectedLabel) {
        tom.addOption({ id: selectedId, label: selectedLabel });
        tom.setValue(selectedId);
    }
});

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




