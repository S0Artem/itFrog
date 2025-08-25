import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/css/app.css',
                'resources/views/home/component/banner/banner.css',
                'resources/views/home/component/main/main.css',
                'resources/views/home/component/courses/courses.css',
                'resources/views/home/component/form/form.css',
                'resources/views/profil/profil.css',
                'resources/views/home/component/time/time.css',
                'resources/views/home/component/portfolio/portfolio.js',
                'resources/views/home/component/portfolio/portfolio.css',
                'resources/views/components/layout.css',
                'resources/views/components/layout.js',
                'resources/views/auth/login/login.css',
                'resources/views/admin/shedule/shedule.js',
                'resources/views/admin/shedule/shedule.css',
                'resources/views/admin/adminRegister/user/register.css',
                'resources/views/admin/adminRegister/student/registerStudentFilter.js',
                'resources/views/admin/adminRegister/student/register.css',
                'resources/views/home/component/form/form.js',
                'resources/views/admin/adminRegister/employee/register.css',
                'resources/views/admin/adminPortfolio/portfolio.js',
                'resources/views/admin/adminPortfolio/portfolio.css',
                'resources/views/admin/adminAplication/aplication.css',
                'resources/views/admin/groupInfo/groupInfo.css',
                'resources/views/admin/adminUsers/adminUsers.css',
                'resources/views/directions/show.css',
                'resources/views/teacher/createPortfolio/createPortfolio.js',
                'resources/views/teacher/createPortfolio/createPortfolio.css',
            ],
        }),
    ],
});