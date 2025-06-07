# Proyecto 4
## Descripcion
Este proyecto consta de una base de datos en Postgres implementada utilizando Laravel / Eloquent, la base de datos soporta operciones basicas para manejar odenes, usuarios e inventario de un E-Commerce. Cuenta con dos CRUDs, uno para usuarios y otro para productos implementados completamente desde Eloquent. Dentro del proyecto utilizamos Laravel para manejar un backend en HTTP y desarrollamos un frontend en React.

## Ubicacion de Archivos

- /backend/ los archivos del proyecto de Laravel
- /frontend/ frontend en React
- /docs/ la documentacion de la base de datos como el diagrama ERD

## Correr el Proyecto
Para correr el proyecto unicamente es necesario correr el siguiente comando para levantar los contenedores de docker
```
docker compose up --build
```
Luego recomendamos bajar el contenedor con
```
docker compose down -v
```

## Estructura Backend

- database/models
  - Los modelos utilizados para representar las entidades / tablas de la base de datos
 
- database/seeders
  - Los scripts de insercion de datos por medio del ORM
 
- database/factories
  - Herramientas de utilidad para generar datos variados para su insercion dentro de la base de datos

- database/migrations
   - Las migraciones dentro de la base de datos, las migraciones se corren en orden y el nombre describe lo que se implementa
 
## Screenshots
