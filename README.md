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
### Productos
- Agregando un producto
  <img src="https://github.com/TonitoMC/dbproy4/blob/main/frontend/src/assets/img/postProduct.png" alt="agregando producto">
- Obteniendo los productos
  <img src="https://github.com/TonitoMC/dbproy4/blob/main/frontend/src/assets/img/getProducts.png" alt="obteniendo productos">
- Editando un producto
  <img src="https://github.com/TonitoMC/dbproy4/blob/main/frontend/src/assets/img/putProduct.png" alt="editando producto">
- Eliminando un producto
  <img src="https://github.com/TonitoMC/dbproy4/blob/main/frontend/src/assets/img/deleteProduct.png" alt="eliminando producto">

### Usuarios
- Agregando un usuario
  <img src="https://github.com/TonitoMC/dbproy4/blob/main/frontend/src/assets/img/postUser.png" alt="agregando usuario">
- Obteniendo los usuarios
  <img src="https://github.com/TonitoMC/dbproy4/blob/main/frontend/src/assets/img/getUsers.png" alt="obteniendo usuarios">
- Editando un usuario
  <img src="https://github.com/TonitoMC/dbproy4/blob/main/frontend/src/assets/img/putUser.png" alt="editando usuario">
- Eliminando un usuario
  <img src="https://github.com/TonitoMC/dbproy4/blob/main/frontend/src/assets/img/deleteUser.png" alt="eliminando usuario">
