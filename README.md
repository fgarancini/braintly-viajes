<p align="center"><img src="https://i.imgur.com/Htvlmil.png" width="400"></p>

# BraintlyViajes

BraintlyViajes es un microservicio dedicado a gestionar la disponibilidad de viajes de distintas aerolíneas a distintos destinos. 

Su principal propósito es servir una API que, dadas las necesidades del usuario, indique cuáles son los vuelos disponibles entre dos puntos.

El código está basado en el Framework Laravel y ya trae toda la base de código necesaria para comenzar a implementar la funcionalidad. Braintly brinda las migraciones, los modelos, las rutas y la estructura de los request y los responses para que el desarrollador pueda realizar la implementación comodamente.

## Consigna

Se le pide al desarrollador implementar los siguientes métodos:
1. Un endpoint que le recomiende al usuario 10 vuelos distintos que mejor se ajusten a su necesidad. El usuario enviará la siguiente información:
```json
{
  "occupants": numeric,
  "departure_airport": string (IATA code),
  "arrival_airport": string (IATA code),
  "check_in": date (yyy-mm-dd), 
  "check_out": date (yyy-mm-dd), 
  "type": economic|firstclass,
}
```

El sistema debe recomendarle 5 vuelos de ida y 5 de vuelta que sean cerca de las fechas indicadas, ordenados por precio.
* El avión debe tener espacio disponible para los ocupantes indicados.
* Se deben mostrar 3 opciones con vuelo directo y 2 opciones con escala (en caso de que el vuelo admita escala). 

Ejemplo de request:
```json
{
  "occupants": 2,
  "departure_airport": AEP,
  "arrival_airport": NYC,
  "check_in": 2020-12-14, 
  "check_out": 2021-01-3, 
  "type": economic,
}
```

Ejemplo de response:
```json
{
  "data": {
    "ida": {
      "departure_airport": "EZE",
      "arrival_airport": "NYC",
      "check_in": "2020-12-14",
      "options": [
        [{
          "airline": "LIONAIR",
          "flight_number": "LNR-003",
          "departure_airport": "EZE",
          "arrival_airport": "NYC",
          "departure_date": "2020-12-14 14:00:00",
          "arrival_date": "2020-12-14 23:00:00",
          "price": 2000,
          "type": "economic"
        }],
        [{
          "airline": "LIONAIR",
          "flight_number": "LNR-005",
          "departure_airport": "EZE",
          "arrival_airport": "SCL",
          "departure_date": "2020-12-14 12:00:00",
          "arrival_date": "2020-12-14 15:00:00",
          "price": 2000,
          "type": "economic"
        },{
          "airline": "LIONAIR",
          "flight_number": "LNR-008",
          "departure_airport": "SCL",
          "arrival_airport": "NYK",
          "departure_date": "2020-12-14 17:00:00",
          "arrival_date": "2020-12-14 22:00:00",
          "price": 2000,
          "type": "economic"
        }]
      ]
    },
    "vuelta": {
      "departure_airport": "NYC",
      "arrival_airport": "EZE",
      "check_out": "2021-01-03",
      "options": [
        [{
          "airline": "LIONAIR",
          "flight_number": "LNR-008",
          "departure_airport": "NYC",
          "arrival_airport": "EZE",
          "departure_date": "2021-01-03 04:00:00",
          "arrival_date": "2021-01-03 17:00:00",
          "price": 2000,
          "type": "economic"
        }],
        [{
          "airline": "LIONAIR",
          "flight_number": "LNR-009",
          "departure_airport": "NYC",
          "arrival_airport": "SCL",
          "departure_date": "2021-01-03 05:00:00",
          "arrival_date": "2021-01-03 15:00:00",
          "price": 2000,
          "type": "economic"
        },{
          "airline": "LIONAIR",
          "flight_number": "LNR-008",
          "departure_airport": "SCL",
          "arrival_airport": "EZE",
          "departure_date": "2021-01-03 15:30:00",
          "arrival_date": "2021-01-03 18:00:00",
          "price": 2000,
          "type": "economic"
        }]
      ]
    }
  }
}

```
#### Consideraciones
* Solo se aplicarán vuelos con escala si la distancia entre ambos aeropuertos es mayor a 5.000 kilómetros.
* La distancia total del viaje al añadir una escala no puede ser superior a la distancia de vuelo directo más un 30%.
* El precio de cada pasaje estará dado por la siguiente fórmula:
    * Si el vuelo es dentro de las próximas 24 horas, se suma un 35% al precio del pasaje.
    * Si el vuelo es dentro de los próximos 7 dias, se suma un 20% al preciod el pasaje.
    * Si el vuelo tiene menos de 10 asientos disponibles, se suma un 8% al precio del pasaje.
    * La primera clase cuesta un 40% más que la clase económica para todos los casos.

## Entregable

Junto con la consigna se entrega un archivo `.sql` (Mysql) para que tengas una DB hidratada para trabajar.

El ejercicio puede desarrollarse en PHP o NodeJS haciendo uso de los frameworks o librerias que necesites. (Sumás puntos si lo hacés en Laravel o Lumen ya que son las tecnologías con las que trabajamos en Braintly)

Se tendrán en cuenta:
* Que el código cumpla con la consigna sin errores.
* Principios de diseño y programación orientada a objetos.
* Principios de diseño de API Rest.
* Buen uso de MVC.
* Buen diseño de las consultas a la base de datos.

No te preocupes si hay alguno de los puntos que no te sale muy bien, intentá resolverlo como puedas, ¡no tiene que estar perfecto!

Vamos a pedirte luego que justifiques alguna de las decisiones que tomaste a la hora de desarrollar el ejercicio :).

El entregable debe ser el código fuente de la solución subida a un repositorio en Github. Por favor compartir el ejercicio a la cuenta [@lucasbraintly](https://github.com/lucasbraintly).

