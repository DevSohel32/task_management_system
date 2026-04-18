# TaskFlow - Task Management System

A modern, full-stack task management application built with Laravel and Vue.js-inspired frontend components. TaskFlow allows users to create, manage, and track their tasks with features like status updates, due dates, and PDF export capabilities.

## Features

- **User Authentication**: Secure login and registration system powered by Laravel Breeze
- **Task Management**: Create, read, update, and delete tasks
- **Task Status Tracking**: Track tasks through pending, in-progress, and completed states
- **Dashboard**: Overview of all tasks and personal task statistics
- **PDF Export**: Generate PDF reports of tasks using DomPDF
- **Responsive Design**: Mobile-friendly interface built with Tailwind CSS and DaisyUI
- **Real-time Updates**: AJAX-powered interactions for seamless user experience

## Technologies Used

### Backend
- **Laravel 13**: PHP web framework for robust backend development
- **PHP 8.3**: Server-side scripting language
- **MySQL/PostgreSQL**: Database management (configurable)
- **Laravel DomPDF**: PDF generation for task reports
- **Laravel Breeze**: Authentication scaffolding

### Frontend
- **Vite**: Fast build tool and development server
- **Tailwind CSS**: Utility-first CSS framework
- **DaisyUI**: Component library for Tailwind CSS
- **Alpine.js**: Lightweight JavaScript framework for reactive components
- **Axios**: HTTP client for API requests
- **Chart.js**: Data visualization library
- **SweetAlert2**: Modern alert and confirmation dialogs
- **FontAwesome**: Icon library

### Development Tools
- **Composer**: PHP dependency management
- **NPM**: Node.js package management
- **PHPUnit**: Unit and feature testing
- **Laravel Pail**: Log monitoring tool

## Setup Instructions

### Prerequisites
- PHP 8.3 or higher
- Composer
- Node.js and NPM
- MySQL or PostgreSQL database

### Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd taskflow
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment Configuration**
   ```bash
   cp .env.example .env
   ```
   Update the `.env` file with your database credentials and other configuration settings.

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **Run Database Migrations**
   ```bash
   php artisan migrate
   ```

7. **Build Frontend Assets**
   ```bash
   npm run build
   ```

### Development Server

To start the development environment with all services running:

```bash
composer run dev
```

This command will start:
- Laravel development server (http://localhost:8000)
- Queue worker for background jobs
- Log monitoring with Pail
- Vite development server for frontend assets

### Production Deployment

1. **Build optimized assets**
   ```bash
   npm run build
   ```

2. **Configure web server** (Apache/Nginx) to serve the `public` directory

3. **Set proper permissions** for storage and cache directories

4. **Run database migrations** on production server

## Database Schema

The application uses the following main tables:

- **users**: User authentication and profile information
- **tasks**: Task data with relationships to users
  - `user_id`: Foreign key to users table
  - `title`: Task title
  - `description`: Task description (optional)
  - `status`: Enum ('pending', 'in_progress', 'completed')
  - `due_date`: Task deadline (optional)
  - `timestamps`: Created and updated timestamps

## Assumptions and Decisions Made

### Architecture Decisions
- **MVC Pattern**: Followed Laravel's Model-View-Controller architecture for clean separation of concerns
- **Service Layer**: Implemented TaskService for business logic separation
- **Repository Pattern**: Not implemented - kept simple with direct Eloquent usage for this scale
- **Authentication**: Used Laravel Breeze for quick setup, could be extended with social login

### UI/UX Decisions
- **Component-Based**: Used Blade components with Alpine.js for reactive interactions
- **Mobile-First**: Responsive design prioritizing mobile experience
- **Dark/Light Theme**: DaisyUI provides theme switching capabilities (not fully implemented)
- **Accessibility**: Basic accessibility considerations with semantic HTML and ARIA labels

### Security Decisions
- **CSRF Protection**: Enabled on all forms via Laravel middleware
- **Input Validation**: Request classes used for validation rules
- **Mass Assignment Protection**: Fillable arrays defined on models
- **SQL Injection Prevention**: Eloquent ORM provides protection

### Performance Decisions
- **Lazy Loading**: Relationships loaded as needed
- **Asset Optimization**: Vite handles code splitting and minification
- **Caching**: Laravel's built-in caching system available for future optimization

## Testing Approach

The application includes both unit and feature tests using PHPUnit and Laravel's testing framework.

### Test Structure
- **Feature Tests**: Located in `tests/Feature/`
  - `TaskCreationTest.php`: Tests task creation functionality
  - Authentication tests in `tests/Feature/Auth/`

- **Unit Tests**: Located in `tests/Unit/`
  - Basic unit test examples

### Running Tests
```bash
# Run all tests
php artisan test

# Run with coverage
php artisan test --coverage

# Run specific test file
php artisan test tests/Feature/TaskCreationTest.php
```

### Testing Strategy
- **Database Refresh**: Uses `RefreshDatabase` trait for clean test database
- **Factory Usage**: User factory for test data generation
- **HTTP Testing**: Tests API endpoints and form submissions
- **Assertion Methods**: Database assertions and response status checks

### Test Coverage
Current tests cover:
- User authentication flow
- Task creation with validation
- Database persistence verification

### Future Testing Improvements
- Add more comprehensive feature tests for all CRUD operations
- Implement API testing for AJAX endpoints
- Add browser testing with Laravel Dusk
- Increase test coverage to >80%

## API Endpoints

### Authentication Required Routes
- `GET /dashboard` - User dashboard
- `GET /all-tasks` - View all tasks (admin view)
- `GET /my-tasks` - User's personal tasks
- `POST /my-tasks/store` - Create new task
- `PUT /my-tasks/update/{id}` - Update task
- `DELETE /my-tasks/destroy/{id}` - Delete task
- `PATCH /my-status-update/{id}` - Update task status
- `POST /export-pdf` - Generate PDF report

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [sujauddoulasohe352@gmail.com](mailto:sujauddoulasohe352@gmail.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
