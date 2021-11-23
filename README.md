# Sunspot Tours Test

Welcome to the take home technical test, please read through this file before starting.

-   Create an API endpoint to fetch a single hotel by ID with reviews (if any).

    -   **DO** return the response as JSON.
    -   The response **SHOULD** only include:

        -   The name of the hotel.
        -   The hotel star rating.
        -   The reviews of the hotel (if any).

    -   The endpoint should **NOT** return inactive hotels.

-   You will need to create the migrations and factories to seed dummy data.
-   **DO** write tests.

## Hotels data will include

-   Hotel name
-   Hotel star rating (between 1 - 5)
-   Hotel address
-   Supplier - One of (Own, HotelBeds or SunHotels)
-   Active - Is the hotel active or not?
-   The date the record was created at and updated at

## Review data will include

A hotel can have zero or more reviews.

-   Review title
-   Description of the review
-   Author
-   Date review was made
+++++++++++++++++++++++++++++++++++++++++++++++++++++
TO run this project follow below instrunction
1) clone this project 
2) in cmd go to root folder then type "composer install"
3) Generate the .env file 
4) set database in env file & in cmd type "php artisan config:clear"
5) in cmd in root folder type "php artisan migrate" to generate the database schema
6) then type "php artisan db:seed" to add dummy data
7) By this url you will get all the hotel data based on hotel id
http://localhost/laravel-api-test/public/api/hotel/2 
hear 2 is hotel id
