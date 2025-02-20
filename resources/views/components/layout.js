let dropdown = document.getElementById('dropdown');
let dropdown__address = document.getElementById('dropdown__address');
let dropdown__menu = document.getElementById('dropdown__menu');
dropdown__address.onclick = openDropdown;
function openDropdown() {
    if (dropdown__menu.classList.contains('open')) {
        dropdown__menu.classList.remove('open');
    }
    else{
        dropdown__menu.classList.add('open');
    }
}


document.addEventListener('click', function (e) {
    let isClickInside = dropdown.contains(e.target);

    if (!isClickInside) {
        dropdown__menu.classList.remove('open');
    }
});












let dropdown__menu__items = document.getElementsByClassName('dropdown__menu__item');
Array.from(dropdown__menu__items).forEach(item => {
    item.onclick = clickItem;
});

function clickItem(event) {
    let clickedItem = event.target;
    let textClickedItem = clickedItem.textContent;
    let textDropdown__address = dropdown__address.textContent;
    if (clickedItem.id === 'Kazan') {
        dropdown__address.textContent = textClickedItem;
        clickedItem.textContent = textDropdown__address;
    } else if (clickedItem.id === 'Novosibirsk') {
        dropdown__address.textContent = textClickedItem;
        clickedItem.textContent = textDropdown__address;
    } else if(clickedItem.id === "Moskow"){
        dropdown__address.textContent = textClickedItem;
        clickedItem.textContent = textDropdown__address;
    }
    dropdown__menu.classList.remove('open');
}
