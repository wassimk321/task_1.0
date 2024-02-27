## Installation
1-Clone the repository to your local machine:
    git clone https://github.com/wassimk321/task_1.0.git

2-Navigate into the project directory:
    cd project directory

3-Install PHP dependencies using Composer
    composer install

4-Copy the (.env.example) file and rename it to (.env):
    cp .env.example .env

5-Generate an application key:
    php artisan key:generate
    note: you may have to generate jwt key using command php artisan jwt:generate

6-Configure your database in .env file:

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password

7-Run database migrations to create tables:
    php artisan migrate

8-Seed the database with sample data:
    php artisan db:seed

9-Run the project locally:
    php artisan serve

## User credentials
 phone: 938385476
 email: admin@admin.com
 password: 1234567890

 you can use this credentials for login

