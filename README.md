# VeriFarma Laravel CRUD API Farmacias
REST API para la carga de farmacias, con sus respectivas coordenadas de ubicacion (Latitud y Longitud) y sistemas de consulta de las mismas por cercania.

### Requisitos
- Composer 2.5.8 o posterior
- Docker 24.0.5 o posterior
- Laravel 10 o posterior
- PHP 8.1 o posterior
- PostGres 12 o posterior
  - Adicionalmenete, habilitar las siguientes extensiones: cube && earthdistance (https://www.postgresql.org/docs/current/earthdistance.html);
  
## Instalacion:
Descargar el repositorio, y una vez dentro del directorio del proyecto, ejecutar los siguientes comandos:

Instalamos la base de datos en Docker
``` r
docker compose up -d db
```

Verificar que la base de datos se este ejecutandose 
``` r
docker ps -a
```

Construimos el proyecto
``` r
docker compose build
```

Ejecutamos el proyecto y ejecutamos la migracion para la creacion de la base de datos (El comando de migracion debe ejecutarse al mismo momento que el proyecto se encuentra ejecutandose)
``` r
docker compose up laravelapp
docker compose exec laravelapp php artisan migrate
```

¡LISTO! El proyecto esta listo para usarse.


## Uso
A los efectos de esta documentacion se propone utilizar la libreria CURL para las consultas.
Tambien se pueden utilizar herramientras externas como por ejemplo Postman (https://www.postman.com/):


*Consulta de farmacias:*
Esta llamada, devuelve todoas las farmacias registradas en la base de datos
``` r
**curl -X GET http://localhost/api/farmacias/**
```

*Consulta de farmacia:*
Esta llamada, devuelve los datos de una farmacia segun su ID
``` r
**curl -X GET http://localhost/api/farmacias/5**
```

*Insertar una farmacia*
Esta llamada inserta una farmacia en la base de datos
``` r
curl -X POST http://localhost/api/farmacias/ -d 'nombre=PHARMACY San Martin&direccion=B1604DEB Gran Buenos Aires, Gral. José de San Martín 3257, B1604DEB Florida, Provincia de Buenos Aires&latitud=-34.53174029238471&longitud=-58.50503227409527'
```

*Actualizar una farmacia*
Esta llamada actualiza una farmacia en la base de datos
``` r
curl -X POST http://localhost/api/farmacias/5 -d 'nombre=PHARMACY San Martin&direccion=B1604DEB Gran Buenos Aires, Gral. José de San Martín 3257, B1604DEB Florida, Provincia de Buenos Aires&latitud=-34.53174029238471&longitud=-58.50503227409527'
```

*Elimino una farmacia:*
Esta llamada, elimina de la base de datos de una farmacia segun su ID
``` r
**curl -X DELETE http://localhost/api/farmacias/5**
```

*Buscar farmacias por cercania*
Esta llamada busca las farmacias mas cercadas, en funcion de una latitud y longitud dada
``` r
curl -X PUT http://localhost/api/farmacias/ -d 'latitud=-34.53174029238471&longitud=-58.50503227409527'
```


## Test unitarios
Se definieron 3 casos de uso:

# test_farmacia_insert_ok
Inserta una farmacia en la base de datos con la informacion requerida

# test_farmacia_insert_error
Inserta una farmaciaen la base de datos con la informacion erronea

# test_farmacia_search_ok
Busca las farmacias mas cercanas en funcion de valores validos dados de latitud y longitud 

``` r
php artisan test
```


## Autor
Ernesto Arias (https://www.pupila.biz)  

## Licencia
Copyright © 2023, Ernesto Arias <info@apupila.biz>
Todos los derechos reservados
