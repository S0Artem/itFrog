document.addEventListener('DOMContentLoaded', function () {
    const groupSelect = document.getElementById('group_id');
    const studentSelect = document.getElementById('student_id');
    const allOptions = Array.from(studentSelect.querySelectorAll('option')).filter(opt => opt.value);
    const paymentInfo = document.getElementById('payment-info');

    function updatePaymentInfo(option) {
        const payment = option.getAttribute('data-payment');
        let color = option.getAttribute('data-color');

        // Более насыщенный красный
        if (color === 'red') {
            color = '#d90000';
        }

        if (payment && color) {
            paymentInfo.innerHTML = `<span style="color:${color}">Дата последней оплаты: ${payment}</span>`;
        } else {
            paymentInfo.innerHTML = '';
        }
    }

    groupSelect.addEventListener('change', function () {
        const selectedGroupId = this.value;
        studentSelect.disabled = !selectedGroupId;

        let firstOverdueOption = null;
        let firstVisibleOption = null;

        allOptions.forEach(option => {
            const groupIds = option.dataset.groups?.split(',') || [];
            const visible = groupIds.includes(selectedGroupId);
            option.hidden = !visible;

            if (visible) {
                if (!firstVisibleOption) {
                    firstVisibleOption = option;
                }

                // Проверяем, просрочен ли платёж
                const color = option.getAttribute('data-color');
                if (!firstOverdueOption && color === 'red') {
                    firstOverdueOption = option;
                }
            }
        });

        // Сброс текущего значения
        studentSelect.value = '';

        // Сначала выбираем с просрочкой, если есть
        const toSelect = firstOverdueOption || firstVisibleOption;
        if (toSelect) {
            toSelect.selected = true;
            updatePaymentInfo(toSelect);
        } else {
            paymentInfo.innerHTML = '';
        }
    });

    studentSelect.addEventListener('change', function () {
        const selectedOption = studentSelect.options[studentSelect.selectedIndex];
        updatePaymentInfo(selectedOption);
    });
});
