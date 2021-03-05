# gforces-demo-api-microservice

## Prerequisites

- docker installed on your machine.

## Instalation

```sh
git clone https://github.com/knight002/gforces-demo-api-microservice.git
```

```sh
docker-compose build
```

```sh
docker-compose up
```
Once it's up an running run the following to resolve dependencies:
```sh
docker exec -it demo-api-microservice-php composer install
```

Database settings are here for simplicity:

./gforces-demo-api-microservice/config/autoload/global.php
(you can overwrite them by creating local.php):

Make sure those settings match your docker network settings.

The database structure should be created by now but just in case you'll find the structure here:

./gforces-demo-api-microservice/docker/db/docker-entrypoint-initdb.d/init.sql

Mysql server should be exposed on port 3307
```
      MYSQL_DATABASE: dbname
      MYSQL_USER: dbuser
      MYSQL_PASSWORD: dbpassword
```

## Performing requests / API endpoints:

### Creating an order:

###### Request:
```sh
POST http://localhost:8202/v1/orders
```
```json
{

}
```
###### Response:
```json
{
    "uuid": "3334fb1f-7aea-11eb-9df9-0242ac170003",
    "total": null,
    "model": {
        "model": null
    },
    "_links": {
        "self": {
            "href": "http://localhost:8202/v1/orders/3334fb1f-7aea-11eb-9df9-0242ac170003"
        }
    }
}
```
### Retrieving an order:
###### Request:
```sh
GET http://localhost:8202/v1/orders/3334fb1f-7aea-11eb-9df9-0242ac170003
```
###### Response:
```json
{
    "uuid": "3334fb1f-7aea-11eb-9df9-0242ac170003",
    "total": "111",
    "model": {
        "model": "corvette",
        "m_uuid": "6268bdf6-7aea-11eb-9df9-0242ac170003",
        "make": "chevrolet"
    },
    "_links": {
        "self": {
            "href": "http://localhost:8202/v1/orders/3334fb1f-7aea-11eb-9df9-0242ac170003"
        }
    }
}
```
### Amending an order:
###### Request:
```sh
PATCH http://localhost:8202/v1/orders/3334fb1f-7aea-11eb-9df9-0242ac170003
```
```json
{
    "total" : 55511,
    "model" : {
        "make" : "chevrolet",
        "model" : "corvette"
    }
}
```

### Source
For simplicity you'll find the source here.
https://github.com/knight002/gforces-demo-api-microservice/tree/master/module/Vechicle
However this should be split into some packages.
The RestApiGeneralInterface.php should live in some rest api related package.
The OrdersTableGateway.php with it's factory should also live inside a separate package and implement methods from the interface. So in case we need to change the storage to something else we just switch to a different package implementing that interface.

### Infrastructure
Docker file provides the basic infrastructure:
https://github.com/knight002/gforces-demo-api-microservice/blob/master/docker/docker-compose.yaml
The nginx node can be autoscaled horizontaly if required and placed across different regions and AZs.
The mysql/RDS needs to maintain the central data point for write. Read replicas could have been set if the data wasn't changed frequently.

### Performance
The api responds within 110ms running in docker. With memory virtualization enabled response times around 20ms should be achievable.

### Authentication / security
Depending whether the api needs to be exposed to the public primarly I would hide it behind a private network. But if it's not the case then something like:
- limiting per domain / ip,
- enabling CORS
- introducing oAuth type authentication

### Input validation
Just as an example I've setup a validation for 'total' field. That's by applying a regex to the input but this can be any validator class.
https://github.com/knight002/gforces-demo-api-microservice/blob/master/module/Vechicle/config/module.config.php#L89-L107

#### Things to consider (point 1):
There seems to be no reason for creating an empty order (without a product / vechicle) just to obtain a uuid.
The order uuid can be created along with model/manuf. update.
There is no reason to create it in point 1. Unless it's needed for other operations between point 1 and 2.
