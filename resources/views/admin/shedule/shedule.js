document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('scheduleModal');
    const form = document.getElementById('scheduleForm');
    
    const scheduleData = [];
    const timeSlots = document.querySelectorAll('.time-slot');
    
    timeSlots.forEach((timeSlot, timeIndex) => {
        const daySlots = [];
        const lessonSlots = document.querySelectorAll(`.lesson-slot[data-time-index="${timeIndex}"]`);
        
        lessonSlots.forEach(lessonSlot => {
            daySlots.push({
                element: lessonSlot,
                day: lessonSlot.dataset.day
            });
        });
        
        scheduleData.push({
            timeSlot: timeSlot,
            timeId: timeSlot.dataset.timeId,
            days: daySlots
        });
    });

    document.querySelectorAll('.lesson-add').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const lessonSlot = this.closest('.lesson-slot');
            const timeIndex = lessonSlot.dataset.timeIndex;
            const day = lessonSlot.dataset.day;
            const branchId = document.getElementById('modal_branch_id').value;
            
            const timeData = scheduleData[timeIndex];
            const timeId = timeData?.timeId;
            
            console.log('Отладочная информация:', {
                timeIndex: timeIndex,
                timeId: timeId,
                day: day,
                branchId: branchId,
                timeData: timeData
            });
            
            if (!timeId || !day || !branchId) {
                console.error('Отсутствуют обязательные данные:', {
                    timeId: timeId,
                    day: day,
                    branchId: branchId
                });
                return;
            }
            
            document.getElementById('modal_time_id').value = timeId;
            document.getElementById('modal_day').value = day;
            
            modal.style.display = 'block';
        });
    });
    
    document.querySelectorAll('.modal-close, .btn-secondary').forEach(btn => {
        btn.addEventListener('click', () => {
            modal.style.display = 'none';
        });
    });
    
    window.addEventListener('click', (e) => {
        if (e.target === modal) modal.style.display = 'none';
    });
});