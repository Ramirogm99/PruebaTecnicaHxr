Un cliente almacena los datos de ocupación de su establecimiento en una cadena de 32 posiciones donde cada posición es un número entre 0 y 9. Cada posición representa media hora desde las 08:00 a las 24:00.

Necesitamos una clase que a partir de ese número construya un array donde la clave identifique el tramo horario y el valor sea dicho número entre 0 y 9.

El valor devuelto debe ser similar a:

[
    '08:00' => 3,
    '08:30' => 0,
    '09:00' => 1,
    ...
    '23:30' => 0
]