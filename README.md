# Booker Lite
Work in progress!

##  Functionality
Booker Lite provides you with all necessary features to run a booking website for your company's services.

# Services
Manage services your company provides. That includes name, description, duration, employees, price, availability.

# Employees
Manage your employees and attach them to services That includes personal information, services, availability.

# Configuration
Configure your working hours, booking interval, vacations, etc.

# Reservations
Visitors can make reservation choosing: service, employee and available time slot. You can manage reservations made by visitors.

## Requirements
- PHP 8.0
- Laravel 9.19
- MySql 8.0

## Installation 
 - Fill up your `.env`
 - Run:
    ```
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php80-composer:latest \
        composer install --ignore-platform-reqs
    ```
 - Run `./vendor/bin/sail up`
