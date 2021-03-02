# gforces-demo-api-microservice

## Prerequisites

- docker installed on your machine.

## Instalation

```sh
docker-compose up -d
```

data change interface separate library which is a dependency of implementation library


- Things to consider (point 1):
There seems to be no reason for creating an empty order (without a product / vechicle) just to obtain a uuid.
The order uuid can be created along with model/manuf. update.
There is no reason to create it in point 1. Unless it's needed for other operations between point 1 and 2.


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