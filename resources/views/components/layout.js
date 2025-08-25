// Скрипт для скрытия прелоадера после загрузки всех ресурсов
            window.addEventListener('load', function() {
                const preloader = document.getElementById('preloader');
                if (preloader) {
                    setTimeout(() => {
                        preloader.classList.add('hidden');
                        setTimeout(() => {
                            preloader.remove();
                        }, 500);
                    }, 500);
                }
            });


            document.querySelector('.burger-menu').addEventListener('click', function() {
            this.classList.toggle('active');
            document.querySelector('.header__ul').style.display = this.classList.contains('active') ? 'flex' : 'none';
        });