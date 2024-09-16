# Tax Calculator

This repository contains a **Tax Calculator** solution, designed as an enterprise-scale application using **React.js**, **PHP 8.3**, and **API Gateway** and microservice architecture. It calculates UK Income Tax based on defined tax bands and offers an intuitive user interface for tax calculation.

## Project Structure

- **Frontend (React.js)**: Located in the `frontend/tax-frontend` directory, the frontend allows users to input their gross salary and displays the tax results.
  - URL: `http://127.0.0.1:3000/`

- **API Gateway**: Manages the communication between the frontend and the backend services. It routes the requests to appropriate microservices.
  - URL: `http://127.0.0.1:8080/`

- **Backend Microservices**:
  - **Reports Service** (`backend/reports-service`): Provides tax calculation reports.
    - URL: `http://127.0.0.1:8001/`
  - **Tax Service** (`backend/tax-service`): Calculates taxes based on UK tax bands.
    - URL: `http://127.0.0.1:8002/`

## Components Used

### Frontend

- **React.js 18.3.1**: Main library for building the UI.
- **Node**: v20.3.0
- **Npm**: 9.6.7
- **React Router DOM**: For navigation and routing.
- **Axios**: For making HTTP requests to the backend services.
- **Tailwind CSS**: Used for styling the application.

### Backend (PHP Services)

- **PHP 8.3**: Backend logic is implemented using modern PHP.
- **PSR-4 Autoloading**: Follows PSR-4 for autoloading classes.
- **Guzzle HTTP**: Used in the API gateway for making HTTP requests.
- **PHPUnit**: For unit testing the backend services.

## Setup Instructions

### Prerequisites

Ensure that you have the following installed on your machine:
- Node.js and npm (for the frontend)
- PHP 8.3 (for the backend microservices)
- Composer (for managing PHP dependencies)

### Steps

1. **Clone the repository**:
   ```bash
   git clone https://github.com/Raducu89/tax-calculator.git
   cd tax-calculator

2. **Install Frontend dependencies**:
   ```bash
   cd frontend/tax-frontend
   npm install

3. **Install Backend dependencies**: For **tax-service** run the following command. **reports-service** is a work in progress.
   ```bash
   composer install

4. **Import the database**: 

5. **Update the .env file**:
   ```bash
   DB_HOST=localhost
   DB_NAME=tax_service
   DB_USERNAME=
   DB_PASSWORD=

6. **Start the frontend**: 
   ```bash
   npm start

7. **Start the API Gateway**: 
   ```bash
   php -S 127.0.0.1:8080

8. **Start the backend service (tax_service)**: 
   ```bash
   php -S 127.0.0.1:8001 -t public

9. **Access the Application**:  Open your browser and go to `http://127.0.0.1:3000/` to interact with the frontend.


## TODO

- Add Redis for Caching: Implement Redis to store frequently accessed data and reduce API response times.
- Rate Limiting: Integrate rate limiting in the API gateway to prevent abuse.
- Load balancer
- CSRF Protection: Secure the frontend against CSRF attacks, especially for form submissions.


## Testing 

Go to `backend/tax_service` and run `./vendor/bin/phpunit --testdox`