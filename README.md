# Project Management API

A Laravel-based API for managing projects, users, timesheets, and dynamic attributes using the EAV model.

---

## 🚀 Setup Instructions

### **1. Clone the Repository**
git clone https://github.com/AbdulHadijatoi/back_assessment.git
cd backend_assessment

## 2. Install Dependencies
composer install


## 3. Set Up Environment
Copy the example environment file and update the database configuration:
cp .env.example .env

## Update .env file:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

## 4. Generate Application Key
php artisan key:generate


## 5. Run Migrations & Seed Database
php artisan migrate --seed

## 6. Install Laravel Passport
php artisan passport:install

## Update config/auth.php:
'guards' => [
    'api' => [
        'driver' => 'passport',
        'provider' => 'users',
    ],
],


## Clear and restart:
php artisan config:clear
php artisan serve




### 📡 API Documentation

## 1. Authentication
## Register a new user
## Endpoint: POST /api/register
## Request:
{
    "first_name": "John",
    "last_name": "Doe",
    "email": "john@example.com",
    "password": "pass1234",
    "password_confirmation": "pass1234"
}

## Response:
{
    "message": "User registered successfully",
    "token": "generated_access_token"
}


## Login
## Endpoint: POST /api/login
## Request:
{
    "email": "john@example.com",
    "password": "pass1234"
}

## Response:
{
    "token": "generated_access_token",
    "user": {
        "id": 1,
        "first_name": "John",
        "last_name": "Doe",
        "email": "john@example.com"
    }
}


## Logout
## Endpoint: POST /api/logout
## Headers:
{
    "Authorization": "Bearer your_access_token"
}


## Response:
{
    "message": "Logged out successfully"
}

## 2. Projects
## Get All Projects
## Endpoint: GET /api/projects
## Headers:
{
    "Authorization": "Bearer your_access_token"
}


## Response:
[
    {
        "id": 1,
        "name": "Project A",
        "status": "Active",
        "attribute_values": [
            {
                "attribute": {
                    "name": "Department",
                    "type": "text"
                },
                "value": "IT"
            }
        ]
    }
]


## Get Project by ID
## Endpoint: GET /api/projects/{id}

## Create Project
## Endpoint: POST /api/projects
## Request:
{
    "name": "Project B",
    "status": "In Progress"
}

## Update Project
## Endpoint: PUT /api/projects/{id}

## Delete Project
## Endpoint: DELETE /api/projects/{id}



## 3. Dynamic Attributes (EAV)
## Create Attribute
## Endpoint: POST /api/attributes
## Request:
{
    "name": "Start Date",
    "type": "date"
}


## Set Attribute Value for Project
## Endpoint: POST /api/projects/{id}/attributes
## Request:
{
    "attribute_id": 1,
    "value": "2024-03-01"
}


## Filter Projects by Attributes
## Endpoint: GET /api/projects?filters[name]=ProjectA&filters[department]=IT

### 🔑 Test Credentials
## Use the following test credentials for authentication:

Email: abdulhadijatoi@gmail.com
Password: pass1234


### ✅ Testing API in Postman
## Import the provided Postman collection (found in /postman_collection.json).
## Set the base_url in the Postman environment.
## Use the test credentials to authenticate and test the endpoints.