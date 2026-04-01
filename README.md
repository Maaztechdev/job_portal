Laravel Job Portal – Easy Guide

This is a simple job portal built with Laravel (PHP).

Employers can post jobs and see applicants.
Job seekers can search jobs, save, apply, and message employers.
Admin can manage users, companies, categories, and jobs.

Requirements:
PHP 8.1+, Composer, MySQL, Node.js + npm, Laravel 11+

Setup Steps:

Clone the project:

git clone https://github.com/YOUR-USERNAME/job_portal.git
cd job_portal

Install dependencies:

composer install
npm install

Copy .env and generate app key:

cp .env.example .env
php artisan key:generate

Edit .env with your database info:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=job_portal
DB_USERNAME=root
DB_PASSWORD=

Migrate and seed the database:

php artisan migrate --seed

Build assets and run server:

npm run build
php artisan serve
Open in browser: http://127.0.0.1:8000

Example Accounts:

Admin: admin@example.com / password
Employer: employer@example.com / password
Seeker: seeker@example.com / password

Folders:

app/Models — Models
app/Http/Controllers — Controllers
resources/views — Frontend pages
routes/web.php — Routes

Screenshots:

![Home](/screenshot/Home.png)
![Admin Dashboard](/screenshot/admin_dashboard.png)
![Employer Dashboard](/screenshot/employer_dashboard.png)
![Employer Create Job](/screenshot/employer_jobs_create.png)
![Seeker Dashboard](/screenshot/seeker_dashboard.png)

