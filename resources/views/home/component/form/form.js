import Inputmask from 'inputmask';

document.addEventListener('DOMContentLoaded', function () {
    // Инициализация маски для телефона
    Inputmask({
        mask: "+7(999)-999-99-99",
        placeholder: "_", // Символ-заполнитель
        clearIncomplete: true, // Очищать неполные значения
        showMaskOnHover: false, // Не показывать маску при наведении
        onBeforePaste: function (pastedValue, opts) {
            // Очищаем вставляемое значение от лишних символов
            const cleanedValue = pastedValue.replace(/\D/g, '');
            return cleanedValue;
        }
    }).mask(document.getElementById('phone'));
});