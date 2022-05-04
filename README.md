# Homelane Price Prediction Bot 
---

# Table of Contents
  - [Requirements & Installation](#requirements-installation)
  - [Available APIs](#available-apis)
  - [Microservices](#micro-services)
    - [Data Service](#data-service)
      - [Data API](#data-api)
    - [Query service](#query-service)
      - [Budget Homes API](#budget-homes-api)
      - [SQFT Homes API](#sqft-homes-api)
      - [Age Homes API](#age-homes-api)
      - [Standard Price API](#standard-price-api)
---

# Requirements & Installation
- PHP 7.4
- Composer 2.0+
- Data service 
  - https://github.com/skthon/homelane-data-service
  - https://homelane-laravel-data.herokuapp.com/
- Query service
  - https://github.com/skthon/homelane-query-service
  - https://homelane-laravel-query.herokuapp.com/
- Installation and commands
  - Create a folder and Clone the repos from above
    ```
    gh repo clone skthon/homelane-query-service
    gh repo clone skthon/homelane-data-service
    ```
  - Run the below commands in both the services
    ```
        # Data service
        composer install
        php artisan migrate
        php artisan db:seed
        php artisan serve --port=8081

        # Query service
        composer install
        php artisan migrate
        php artisan db:seed
        php artisan serve
    ```
---

# Notes on know issues
- Currently facing issues with the heroku mysql/sqlite/pgsql. Tried all of them, there are multiple issues popped up with each of them. The price column doesn't contain the accurate value as it is trimmed to three digit number in mysql db. This needs to be fixed.
- Although there are multiple issues on heroku, but the local installation will work fine with sqlite database.
- In online application, the API response could be considerably slow since the heroku tries to go to sleep when its idle for 30 minutes.
---

# Available APIs

- Demo account
  - email: demo@homelane.com
  - password: `demopassword`
  - access_token: `4|apfnqS5VhIRdOilrLKbrwc3WorajoghNIYVXaBxH`


- Register account using api. This will return the access token/bearer token for accessing APIs. 

    ```
    curl -X POST "https://homelane-laravel-query.herokuapp.com/api/account/register" \
        -H "Accept: application/json" \
        -H "Content-Type: application/json" \
        -d '{"name": "<>", "email":"<>", "password":"<>"}'
    ```

- Login to account using api. This will return the access token/bearer token for accessing APIs. 

    ```
    curl -X POST "https://homelane-laravel-query.herokuapp.com/api/account/login" \
        -H "Accept: application/json" \
        -H "Content-Type: application/json" \
        -d '{"email":"<>", "password":"<>"}'
    ```

- Budget Homes API

    ```
    curl -X POST "https://homelane-laravel-query.herokuapp.com/api/homes/budget" \
        -H "Accept: application/json" \
        -H "Content-Type: application/json" \
        -H "Authorization: Bearer 4|apfnqS5VhIRdOilrLKbrwc3WorajoghNIYVXaBxH" \
        -d '{"minPrice":10, "maxPrice":1000000000}'
    ```

- Sqft Homes API

    ```
    curl -X POST "https://homelane-laravel-query.herokuapp.com/api/homes/sqft" \
        -H "Accept: application/json" \
        -H "Content-Type: application/json" \
        -H "Authorization: Bearer 4|apfnqS5VhIRdOilrLKbrwc3WorajoghNIYVXaBxH" \
        -d '{"minSqft":5000}'
    ```

- Age Homes API

    ```
    curl -X POST "https://homelane-laravel-query.herokuapp.com/api/homes/age" \
        -H "Accept: application/json" \
        -H "Content-Type: application/json" \
        -H "Authorization: Bearer 4|apfnqS5VhIRdOilrLKbrwc3WorajoghNIYVXaBxH" \
        -d '{"year":2010}'
    ```

- Standard Price API (response contains `standardized_price` field)

    ```
    curl -X POST "https://homelane-laravel-query.herokuapp.com/api/homes/standard_price" \
        -H "Accept: application/json" \
        -H "Content-Type: application/json" \
        -H "Authorization: Bearer 4|apfnqS5VhIRdOilrLKbrwc3WorajoghNIYVXaBxH" \
        -d "{}"
    ```

- Accessing data service directly. 

    ```
    curl -X POST "https://homelane-laravel-data.herokuapp.com/api/data" \
        -H "Accept: application/json" \
        -H "Content-Type: application/json" \
        -d '{"min_price": 0,"max_price": 100000000000000,"min_sqft_living": 10,"min_year": 1800,"bypass_ip": true}'
    ```

---
# Microservices

## Data Service

### Data API

- POST request
- URLS
  - http://localhost:8081/api/data
  - https://homelane-laravel-data.herokuapp.com/api/data
- Accepted parameters
  - `min_year`
    - Accepts integer.
    - Used by Age Homes API 
  - `max_price` 
    - Accepts integer.
    - Used by Budget Homes API
  - `min_price` 
    - Accepts integer.
    -  Used by Budget Homes API
  - `min_sqft_living` 
    - Accepts integer.
    - Used by Sqft Homes API
  - `bypass_ip` 
    - Accepts boolean.
    - This needs to be specified in the api to bypass ip address restrictions. This is a serious security issue and need to be avoided, but since heroku platform doesn't support static ip address, i have implemented this for temporary purpose.
- POST Request body
    ```
    {
        "min_price": 0,
        "max_price": 10000000000000,
        "min_sqft_living": 10,
        "min_year": 1800,
        "bypass_ip":true
    }
    ```
- Response Body
    ```
    {
        "data": [
            {
                "id": 1,
                "uuid": "9635a34f-83ff-4285-873e-1248825a96fd",
                "date": "2014-05-02T00:00:00.000000Z",
                "price": "313000.0",
                "bedrooms": "3",
                "bathrooms": "1.5",
                "sqft_living": "1340",
                "sqft_lot": "7912",
                "floors": "1.5",
                "waterfront": "0",
                "view": "0",
                "condition": "3",
                "sqft_above": "1340",
                "sqft_basement": "0",
                "year_built": "1955",
                "year_renovated": "2005",
                "street": "18810 Densmore Ave N",
                "city": "Shoreline",
                "state_zip": "WA 98133",
                "country": "USA",
                "created_at": "2022-05-03T09:46:13.000000Z",
                "updated_at": "2022-05-03T09:46:13.000000Z",
                "standardized_price": 442566.48
            },
            .....
        ]
    }
    ```
- Errors
    - Internal error with 500 response
    - Invalid input with 400 response
---

## Query service

### Budget Homes API
- POST request
- URLS
  - http://127.0.0.1:8000/api/homes/budget
  - https://homelane-laravel-query.herokuapp.com/api/homes/budget
- POST Request body
```
{
    "minPrice": 100,
    "maxPrice": 1000000000
}
```
- Response Body
    ```
    {
        "data": [
            {
                "id": 1,
                "uuid": "9635a34f-83ff-4285-873e-1248825a96fd",
                "date": "2014-05-02T00:00:00.000000Z",
                "price": "313000.0",
                "bedrooms": "3",
                "bathrooms": "1.5",
                "sqft_living": "1340",
                "sqft_lot": "7912",
                "floors": "1.5",
                "waterfront": "0",
                "view": "0",
                "condition": "3",
                "sqft_above": "1340",
                "sqft_basement": "0",
                "year_built": "1955",
                "year_renovated": "2005",
                "street": "18810 Densmore Ave N",
                "city": "Shoreline",
                "state_zip": "WA 98133",
                "country": "USA",
                "created_at": "2022-05-03T09:46:13.000000Z",
                "updated_at": "2022-05-03T09:46:13.000000Z",
                "standardized_price": 442566.48
            },
            .....
        ]
    }
    ```
- Errors
    - Internal error with 500 response
    - Invalid input with 400 response

### SQFT Homes API
- POST request
- URLS
  - http://127.0.0.1:8000/api/homes/sqft
  - https://homelane-laravel-query.herokuapp.com/api/homes/sqft
- POST Request body
    ```
    {
        "minSqft": 10,
    }
    ```

- Response Body
    ```
    {
        "data": [
            {
                "id": 1,
                "uuid": "9635a34f-83ff-4285-873e-1248825a96fd",
                "date": "2014-05-02T00:00:00.000000Z",
                "price": "313000.0",
                "bedrooms": "3",
                "bathrooms": "1.5",
                "sqft_living": "1340",
                "sqft_lot": "7912",
                "floors": "1.5",
                "waterfront": "0",
                "view": "0",
                "condition": "3",
                "sqft_above": "1340",
                "sqft_basement": "0",
                "year_built": "1955",
                "year_renovated": "2005",
                "street": "18810 Densmore Ave N",
                "city": "Shoreline",
                "state_zip": "WA 98133",
                "country": "USA",
                "created_at": "2022-05-03T09:46:13.000000Z",
                "updated_at": "2022-05-03T09:46:13.000000Z",
                "standardized_price": 442566.48
            },
            .....
        ]
    }
    ```

- Errors
    - Internal error with 500 response
    - Invalid input with 400 response

### Age Homes API
- POST request
- URLS
  - http://127.0.0.1:8000/api/homes/age
  - https://homelane-laravel-query.herokuapp.com/api/homes/age
- POST Request body
    ```
    {
        "year": 1900
    }
    ```
- Response Body
    ```
    {
        "data": [
            {
                "id": 1,
                "uuid": "9635a34f-83ff-4285-873e-1248825a96fd",
                "date": "2014-05-02T00:00:00.000000Z",
                "price": "313000.0",
                "bedrooms": "3",
                "bathrooms": "1.5",
                "sqft_living": "1340",
                "sqft_lot": "7912",
                "floors": "1.5",
                "waterfront": "0",
                "view": "0",
                "condition": "3",
                "sqft_above": "1340",
                "sqft_basement": "0",
                "year_built": "1955",
                "year_renovated": "2005",
                "street": "18810 Densmore Ave N",
                "city": "Shoreline",
                "state_zip": "WA 98133",
                "country": "USA",
                "created_at": "2022-05-03T09:46:13.000000Z",
                "updated_at": "2022-05-03T09:46:13.000000Z",
                "standardized_price": 442566.48
            },
            .....
        ]
    }
    ```
- Errors
    - Internal error with 500 response
    - Invalid input with 400 response

### Standard Price API
- POST request
- URLS
  - http://127.0.0.1:8000/api/homes/standard_price
  - https://homelane-laravel-query.herokuapp.com/api/homes/standard_price
- POST Request body
    ```
    {}
    ```
- Response Body
    ```
    {
        "data": [
            {
                ....
                "standardized_price": 442566.48
            },
            .....
        ]
    }

    ```
- Errors
    - Internal error with 500 response
    - Invalid input with 400 response