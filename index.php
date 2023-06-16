<?php

require 'flight/Flight.php';
Flight::register('db', 'PDO', array('mysql:host=localhost;dbname=api','root',''));
#LEE Y MUESTRA
Flight::route('GET /alumnos', function () {
    $sentencia= Flight::db()->prepare("SELECT * FROM alumnos");
    $sentencia->execute();
    $datos=$sentencia->fetchAll();
    Flight::json($datos);
});
#RECIBE LOS DATOS POR POST E INSERTA
Flight::route('POST /alumnos', function () {
    $nombres=(Flight::request()->data->nombres);
    $apellidos=(Flight::request()->data->apellidos);
    $sql="INSERT INTO alumnos (nombres,apellidos) VALUES(?,?)";
    $sentencia= Flight::db()->prepare($sql);
    $sentencia->bindParam(1,$nombres);
    $sentencia->bindParam(2,$apellidos);
    $sentencia->execute();
    Flight::jsonp(["Se ha agregado el alumno"]);
});
#Borrar registro
Flight::route('DELETE /alumnos', function () {
    $id=(Flight::request()->data->id);
    $sql="DELETE FROM alumnos WHERE id=?";
    $sentencia= Flight::db()->prepare($sql);
    $sentencia->bindParam(1,$id);
    $sentencia->execute();
    Flight::jsonp(["Se ha eliminado el alumno"]);
});
#Actualizar registro
Flight::route('PUT /alumnos', function () {

    $id=(Flight::request()->data->id);
    $nombres=(Flight::request()->data->nombres);
    $apellidos=(Flight::request()->data->apellidos);
    
    $sql="UPDATE alumnos SET nombres=?, apellidos=? WHERE id=?";
    $sentencia= Flight::db()->prepare($sql);
   
    $sentencia->bindParam(1,$nombres);
    $sentencia->bindParam(2,$apellidos);
    $sentencia->bindParam(3,$id);
    $sentencia->execute();
    Flight::jsonp(["Se MODIFICÓ el alumno"]);


});
# leer un registro determinado
Flight::route('GET /alumnos/@id', function ($id) {
    $sentencia= Flight::db()->prepare("SELECT * FROM alumnos WHERE id=?");
    $sentencia->bindParam(1,$id);
    $sentencia->execute();
    $datos=$sentencia->fetchAll();
    Flight::json($datos);
});
Flight::start();
