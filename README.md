# Proyecto 4
- /docs/ para el diagrama ERD
- /backend/ para el backend en Laravel (si lo separe perdon)
- /frontend/ para el frontend en React
  
## Hecho

- Diseño de la base de datos
- Creación dentro de Eloquent
- Inserción de datos de prueba

## Pendiente:

- Triggers / Funciones
- Views
- CRUDs
- Frontend

## Correr
Con Docker se tiene hot-reloading en el front y en el back, pueden solo correr el contenedor con esto y van a poder hacer cambios que se reflejen de inmediato:
```
docker compose up --build
```
Para bajar el contenedor les sugiero que usen este comando para quitar volumenes y eso
```
docker compose down -v
```

## Estrucutra
Separé backend y frontend porque se me hizo un dolor no tener hot reloading en el front y no lo pude configurar dentro de Laravel, perdon si les quedaba mas facil. 
### Backend (Puerto 8000)
**CRUDs**
- /app/Http
  - /Controllers
    - Hay uno ya predefinido, pero aqui van los CRUDs / todo el funcionamiento interno
  - /Models
    - Aqui estan todos los modelos para ver los campos y eso
- Routes
   - Aqui definen las rutas, ya esta configurado CORS y eso pero solo es mandar los requests al controlador

Entonces para hacer los CRUDs es hacer el controlador en HTTP/controllers y poner las rutas en /routes/

**DB**

Dentro de /database/ esta todo lo de la DB, factories y seeders son solo para la insercion de datos. Las inserciones en algunos puntos se caen a pedazos pero lo voy a terminar de ver.

- /app/migrations
  - Las migraciones de la DB, hay un comando para crear una nueva migracion vacia donde pueden tirar SQL puro para los views
- /app/models
  - Aqui se pueden definir los views directamente si no estoy mal

Entonces para los views / triggers / funciones es crear migracion -> ir al archivo y modificarlo para ejecutar el SQL -> tocar modelos de ser necesario

### Front (Puerto 5173)
Es un proyecto vacío de React con Vite, lo único es que la pantalla por default tira un ping al backend para ver que si jale.
