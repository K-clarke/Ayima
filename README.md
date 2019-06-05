# Ayima TechTest
This is a simple API 
### Prerequisites

*composer
*mysql

### Installing

configure the database connection information in your root directory `.env` 
```
DATABASE_URL=sqlite:///%kernel.project_dir%/var/data.db
```
Install Dependancies
```
composer Install
yarn install
yarn run webpack
```
Create Database
```
 php bin/console doctine:database:create
```
Run migrations
```
 php bin/console doctrine:migrations:migrate
```
Start Server
```
 php bin/console server:start
```

To view end points visit 
```
http://127.0.0.1:8000/marketintel/{domain}

eg 

http://127.0.0.1:8000/marketintel/apple


```

### Notes

Due to my current role I couldn't allocate as much time as i wished. If i had more time to complete the task i would have 

* Added pagination
* Added form imput rather than a query parameter 
* Added a chart using chart.js
* Added unit testing 
