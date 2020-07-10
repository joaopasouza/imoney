<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

### IMoney

Simple REST API example with JWT Authentication

---

First you need to create **.env** file

```shell script
cp .env.example .env
php artisan key:generate
```

#### Routes

##### Auth
prefix: **/api/v1/auth**

- POST: /login
- POST: /register
- POST: /logout
- POST: /refresh
- POST: /me

##### Category
prefix: **/api/v1/categories**

- GET
- GET:id
- POST
- PUT:id
- DELETE:id
