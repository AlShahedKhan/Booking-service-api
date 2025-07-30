# Booking Service API

A Laravel-based booking system with JWT authentication, role-based access, service and booking management, and full PHPUnit test coverage.

---

## 🚀 Features

- JWT Authentication (`tymon/jwt-auth`)
- Role-based Access: Admin & Customer
- Service Management (CRUD by Admin)
- Booking System (User & Admin views)
- Repository Pattern Architecture
- Form Request Validation
- Consistent JSON API Responses
- Pre-seeded Users & Services
- PHPUnit Feature Tests

---

## ⚙️ Installation

```bash
git clone <your-repo-url>
cd Booking-service-api
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
php artisan migrate --seed
```

---


## 🧪 Run Tests

```bash
php artisan test                   # Run all tests
php artisan test --verbose        # Verbose output
php artisan test tests/Feature/AuthTest.php  # Specific file
```

---

## 🧾 API Endpoints Overview

### 🔐 Auth
- `POST /api/login` – Login
- `POST /api/register` – Register

### 🛠 Services
- `GET /api/services` – List services
- `POST /api/services` – Create (admin)
- `PUT /api/services/{id}` – Update (admin)
- `DELETE /api/services/{id}` – Delete (admin)

### 📅 Bookings
- `POST /api/bookings` – Book a service (user)
- `GET /api/bookings` – User's bookings
- `GET /api/admin/bookings` – All bookings (admin)

---

## 🧑‍💻 Default Users

- **Admin:**  
  Email: `admin@test.com`  
  Password: `Zr#82qLp@fTg9wXk`

- **User:**  
  Email: `user@test.com`  
  Password: `Zr#82qLp@fTg9wXk`

---

## 📂 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   ├── Requests/
├── Repositories/
│   ├── Interfaces/
│   └── Implementations/
├── Helpers/
│   └── ApiResponse.php

database/
├── seeders/
├── factories/

tests/
└── Feature/
    ├── AuthTest.php
    ├── ServiceTest.php
    └── BookingTest.php
```

---

## 📜 License

This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).

---

## 🤝 Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.
