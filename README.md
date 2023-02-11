# ✨ Application Features 
<!-- display image here from public folder cover.png -->
<img src="/public/cover.png" alt=“cover” height="500" width="700" style="border-radius:20px">

## 👱 Types of User

- [x] Admin
	- [x] Kitchen manager
	- [x] Deliver Boy
  - [x] Dynamic roles
- [x] Customer

----

## 👱 User Interface

 **Landing Page**
- [x] Ability to display all the food and services
- [x] Create account upon checkout
- [x] Login account

 **About us**
- [x] Contacts info

 **Customer Account**
- [x] List of product 
- Categories
- [x] Profile
- [x] My orders
- [x] My addresses
- [x] Ability to add orders
- COD
- Online Payment (GCASH)

**Admin Account**
- [x] Dashboard
	- [x] Summary (last 30 days)
	- [x] Overview charts
	- [x] Recent activity table
- [x] Categories ✅
	- [x] Create
	- [x] Read
	- [x] Update
	- [x] Delete
- [x] Products ✅
	- [x] Create
	- [x] Read
	- [x] Update
	- [x] Delete
- [x] Orders ✅
	- [x] Read
	- [x] Update
	- [x] Delete
- [x] users ✅
	- [x] Create
	- [x] Read
	- [x] Update
	- [x] Delete
- [x] roles ✅
	- [x] Create
	- [x] Read
	- [x] Update
	- [x] Delete
- [x] orders (status)
- New orders
- Under process orders
- Out to deliver orders
- Delivered orders
- Cancelled orders

**Delivery boy**
- Ability to view and manage delivery status

**Kitchen manager**
- Ability to view and manage delivery status
- Ability to manage all orders

---

## 🛠️ Settings

- [x] Profile
- [x] Address
- [x] Logout

---

## 👨‍🔬 Misc. Features

- [x] Realtime notification
- [x] Realtime events

----

## 🚀 Deployment

- `Domain name` - https://ronaldscatering.com/
- `Hosting platform` - [Laravel Forge](https://forge.laravel.com/)
- `Server platform` - [Digital Ocean](https://www.digitalocean.com/)

## ℹ️ Demo

<b>Links<b>
- `Admin` - https://ronaldscatering.com/admin
- `Customer` - https://ronaldscatering.com/

<b>Admin Credentials<b>

- `Email` - admin@test.com
- `Password` - password

## 🚧 Installation

1. Clone the repository
```bash
  git clone https://github.com/Phojie/restaurant-management-system.git
  cd restaurant-management-system
  ```

2. Install the dependencies
```bash
  composer install
  yarn install 
  ```

3. Copy the example env file and make the required configuration changes in the .env file
```bash 
  cp .env.example .env
  ```

4. Generate a new application key and optimize the application
```bash
  php artisan key:generate && php artisan optimize
  ```

5. Run the database migrations (Set the database connection in .env before migrating)
```bash
  php artisan migrate --seed
  ```

5.  Create a symbolic link from "public/storage" to "storage/app/public"
```bash
  php artisan storage:link
  ```

6. Start the local development server (Vue)
```bash
  yarn dev
  ```

7. Start the local development server (Laravel)
```bash
  php artisan serve
  ```

You're ready to go! Visit in your browser (e.g. http://localhost:8000), and login with:

- **Username:** admin@test.com
- **Password:** password

## 🧪 Running tests
🚧 **Note:** Tests are still in development. 🚧

To run the tests, run:

```bash
php artisan test
```
