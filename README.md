# Simple Learning Management System (LMS)

A Laravel-based Learning Management System with instructor and student roles.

## Features

- User authentication (Instructor & Student roles)
- Course creation and management (Instructors)
- Course browsing and viewing (Students)
- Instructor dashboard
- Course CRUD operations

## Installation

1. Clone the repository
```bash
git clone https://github.com/brylle60/Learning-Management-System.git
cd Learning-Management-System
```

2. Install dependencies
```bash
composer install
npm install
```

3. Configure environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database in `.env`

5. Run migrations
```bash
php artisan migrate
```

6. Start development server
```bash
npm run dev
php artisan serve
```

## Test Accounts

- Instructor: instructor@test.com / password
- Student: student@test.com / password

## Tech Stack

- Laravel 11
- MySQL
- Tailwind CSS
- Blade Templates

## Group Members

1. John Brylle Crodua - Leader
2. Kent Arvile Delig - Developer
3. Ivan Fernandez - Developer
4. Emae Calonia - Developer
5. Francis Velez - Developer

## Live Demo
https://learning-management-system-production-b0bd.up.railway.app/