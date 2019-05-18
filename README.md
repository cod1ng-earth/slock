# slock

[![Build Status](https://travis-ci.org/coding-berlin/slock.svg?branch=master)](https://travis-ci.org/coding-berlin/slock)

This project is based on [API Platform](https://api-platform.com/).

It provides a REST API and a GraphQL API.

## Project setup

The application setup is Docker-based. To initialize it, just run: 

```
make setup
```

After successful setup, usually you only need to run `make start` and `make stop`.

### Additional make commands

- `make restart`: restart application environment 
- `make rebuild`: stop environment, delete all containers, run full setup rebuild again 
- `make fixtures`: generate fixture data for all entities 
- `make migration`: validate schema and create Doctrine migration (when necessary) 
- `make composer-install`: run `composer install` inside container
- `make composer-update`: run `composer update` inside container

For all available commands run `make help`.

## How to access the application

The application has several entrypoint URLs:

Homepage:     http://localhost/
API:          https://localhost:8443/ 
API (cached): https://localhost:8443/ 
Admin:        https://localhost:444/
GraphQL:      https://localhost:8443/graphql

## Filters

### Geo distance filter

You have to use a property `geo` with 3 attributes: 
- `latitude`: float, e.g. 49.132
- `longitude`: float, e.g. 9.2342
- `distance`: integer, in meters, e.g. 5000 for 5km radius

Example for bookings:

https://localhost:8443/bookings?geo[latitude]=49.1&geo[longitude]=9.1&geo[distance]=10000 

### Date filter

You have to use a property `date`.

Example for bookings:

https://localhost:8443/bookings?date[]='2019-05-22' 
