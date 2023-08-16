# SemangQa - Laravel API for React Task Management

SemangQa is a project that provides a Laravel API backend for building a task management application using React on the frontend. The API includes authentication (login and registration) functionality and allows users to manage tasks by adding, deleting, updating, and retrieving specific tasks or all tasks.

## Table of Contents

- [Features](#introduction)
- [Features](#features)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

### Introduction
SemangQa aims to provide a solid foundation for developing a task management application using the Laravel PHP framework for the backend and React for the frontend. This project focuses on implementing authentication and CRUD operations for tasks.
## Features

- User authentication (login , registration, Get User Data )
- Add, delete, update, and retrieve specific tasks.
- Get a list of all tasks.
- Secure API endpoints.


### Prerequisites

Before you begin, ensure you have the following installed:

- PHP >= 8.1
- Composer
- Laravel
- MySQL or another compatible database system
### Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/omarhenidi/SemangQa-Backend.git

2. Clone the repository:

   ```bash
   cd SemangQa-Backend

3. Install the dependencies:

   ```bash
   composer install
### Configuration

1. Create a copy of the .env.example file and name it .env.

2. Configure your database settings in the .env file:

     ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password


3. Generate the application key:

   ```bash
   php artisan key:generate

4. Run database migrations:

   ```bash
   php artisan migrate


### Usage

1. Start the Laravel development server:

    ```bash
    php artisan serve

### Endpoints
- POST /api/register: Register a new user.
- POST /api/login: User login.
- GET /api/tasks: Get a list of all tasks.
- GET /api/tasks/{id}: Get a specific task.
- POST /api/tasks: Add a new task.
- PUT /api/tasks/{id}: Update a task.
- DELETE /api/tasks/{id}: Delete a task.



### Contributing

Contributions are welcome! To contribute to SemangQa, follow these steps:

1. Fork the repository.

2. Create a new branch for your feature or bug fix:
    ```bash
    git commit -m "Add your commit message here"

3. Make your changes and commit them:
    ```bash
    git commit -m "Add your commit message here"

4. Push your changes to your forked repository:
    ```bash
    git push origin feature/your-feature-name

5. Create a pull request on the main repository.

Please follow our Code of Conduct when contributing.







