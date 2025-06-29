# OrderManagement

## Requirements

- PHP >= 8.2
- Composer
- Node.js & npm
- SQLite 

## Installation

1. **Clone the repository**
   ```bash
   git clone <your-repo-url>
   cd <project-directory>
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   - Copy the example environment file and edit as needed:
     ```bash
     cp .env.example .env
     ```
   - Set your database connection in `.env`. By default, SQLite is used:
     ```
     DB_CONNECTION=sqlite
     DB_DATABASE=${PWD}/database/database.sqlite
     ```
   - For MySQL/PostgreSQL, update the relevant fields in `.env`.

5. **Generate application key**
   ```bash
   php artisan key:generate
   ```

6. **Create the SQLite database file (if using SQLite)**
   ```bash
   touch database/database.sqlite
   ```

7. **Run database migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

8. **Build frontend assets**
   ```bash
   npm run build
   ```
   - For development, use:
     ```bash
     npm run dev
     ```

9. **Start the application**
   ```bash
   php artisan serve
   ```
   - Visit [http://localhost:8000](http://localhost:8000) in your browser.

## Default Admin Login

- Email: `admin@example.com`
- Password: `password`

## Additional Notes

- To use a different database, update your `.env` and run the appropriate migration commands.
- For queue and session drivers, see `config/queue.php` and `config/session.php`.
- For testing, use:
  ```bash
  php artisan test
  ```