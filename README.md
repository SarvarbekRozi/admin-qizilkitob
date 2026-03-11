# Qizil Kitob — Admin Panel

Laravel 11 + PHP 8.3 + PostgreSQL admin paneli

## Sozlash (Setup)

### 1. OSPanel da domen qo'shish
OSPanel V6 dasturini oching:
- **Domains** → **Add domain**
- Domain: `admin-qizilkitob.uz`
- Root folder: `D:/OSPanel.V-6/home/admin-qizilkitob/public`
- PHP: `PHP-8.3`

### 2. Database
PostgreSQL da `qizilkitob` database yarating:
```sql
CREATE DATABASE qizilkitob;
```

### 3. .env ni tahrirlang
```
DB_HOST=127.127.126.49   # yoki PostgreSQL IP
DB_DATABASE=qizilkitob
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

### 4. Migration va seeder
```bash
php artisan migrate
```

### 5. Admin login
- URL: http://admin-qizilkitob.uz/login
- Email: admin@qizilkitob.uz
- Password: Admin@2024

## API Endpoints (v2)

### Species
- GET  /api/v2/species
- GET  /api/v2/species/{slug}
- GET  /api/v2/species/featured
- GET  /api/v2/species/stats
- GET  /api/v2/species/map
- GET  /api/v2/species/gallery

### Blog
- GET  /api/v2/blog
- GET  /api/v2/blog/{slug}
- GET  /api/v2/blog/latest
- GET  /api/v2/blog/popular
- GET  /api/v2/blog/categories
- GET  /api/v2/blog/{id}/comments
- POST /api/v2/blog/{id}/comments

### Natural Resources
- GET  /api/v2/natural-resources
- GET  /api/v2/natural-resources/{slug}
- GET  /api/v2/natural-resources/featured
- GET  /api/v2/natural-resources/latest
- GET  /api/v2/natural-resources/categories

### Contact
- POST /api/v2/contact

## Admin Panel Pages
- /admin — Dashboard
- /admin/species — Turlar (CRUD)
- /admin/blog — Blog (CRUD)
- /admin/blog-categories — Blog kategoriyalari
- /admin/natural-resources — Tabiiy boyliklar (CRUD)
- /admin/contacts — Xabarnomalar
- /admin/partners — Hamkorlar (CRUD)

## Nuxt Loyiha
Frontend da quyidagini `.env` ga qo'shing:
```
NUXT_PUBLIC_API_BASE=http://admin-qizilkitob.uz/api/v2
```
"# admin-qizilkitob" 
