document.addEventListener('DOMContentLoaded', function() {
    const birthdateInput = document.getElementById('birthdate');
    const branchSelect = document.getElementById('branch_id');
    const groupSelect = document.getElementById('group_id');
    const groupPlaceholder = document.getElementById('group_placeholder');
    const groupOptions = Array.from(groupSelect.querySelectorAll('option')).filter(opt => opt.id !== 'group_placeholder');
    
    function calculateAge(birthdate) {
        if (!birthdate) return 0;
        const birthDate = new Date(birthdate);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age;
    }
    
    function updateGroups() {
        const birthdate = birthdateInput.value;
        const branchId = branchSelect.value;
        const age = calculateAge(birthdate);
        const ageValid = !!birthdate;
        const branchValid = !!branchId;
        
        groupSelect.disabled = !(ageValid && branchValid);
        
        if (ageValid && branchValid) {
            groupPlaceholder.hidden = true;
            let hasVisibleGroups = false;
            let firstValidGroup = null;
            
            groupOptions.forEach(option => {
                const optionBranch = option.dataset.branch;
                const minAge = parseInt(option.dataset.minAge);
                const maxAge = parseInt(option.dataset.maxAge);
                const ageMatch = age >= minAge && age <= maxAge;
                const branchMatch = optionBranch == branchId;
                
                option.hidden = !branchMatch;
                option.classList.toggle('age-valid', ageMatch && branchMatch);
                option.classList.toggle('age-invalid', !ageMatch && branchMatch);
                
                if (branchMatch) {
                    hasVisibleGroups = true;
                    if (ageMatch && !firstValidGroup) {
                        firstValidGroup = option;
                    }
                }
            });
            
            // Автоматически выбираем первую подходящую группу
            if (firstValidGroup) {
                firstValidGroup.selected = true;
                groupSelect.classList.add('valid-group');
                groupSelect.classList.remove('invalid-group');
            } else if (hasVisibleGroups) {
                // Если есть группы, но возраст не подходит
                const firstVisible = groupOptions.find(opt => !opt.hidden);
                if (firstVisible) firstVisible.selected = true;
                groupSelect.classList.add('invalid-group');
                groupSelect.classList.remove('valid-group');
            }
            
            if (!hasVisibleGroups) {
                groupPlaceholder.hidden = false;
                groupPlaceholder.textContent = 'Нет доступных групп для выбранного филиала и возраста';
                groupSelect.value = '';
                groupSelect.classList.remove('valid-group', 'invalid-group');
            }
        } else {
            groupPlaceholder.hidden = false;
            groupPlaceholder.textContent = 'Сначала выберите филиал и укажите дату рождения';
            groupOptions.forEach(opt => {
                opt.hidden = true;
                opt.selected = false;
            });
            groupSelect.classList.remove('valid-group', 'invalid-group');
        }
    }
    
    birthdateInput.addEventListener('change', updateGroups);
    branchSelect.addEventListener('change', updateGroups);
    groupSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        this.classList.toggle('valid-group', selectedOption.classList.contains('age-valid'));
        this.classList.toggle('invalid-group', selectedOption.classList.contains('age-invalid'));
    });
    
    updateGroups();
});