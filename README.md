# Biblioteca App

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a><a href="https://vue.org" target="_blank"><img src="https://miro.medium.com/v2/resize:fit:500/1*CPDIH8BWrGipHRJ6o6E2Vw.png" width="400" alt="Laravel Logo"></a></p>


## Acerca del proyecto

Este proyecto es un sistema de gestión de bibliotecas que permite administrar autores, libros, préstamos, multas y usuarios. El sistema está diseñado para manejar diferentes tipos de usuarios (docentes, administrativos, alumnos) y ofrece funcionalidades avanzadas como la asignación de múltiples autores a un libro, múltiples libros a un préstamo, y la gestión de préstamos con distintos estados.

## Caracteristicas

- Gestión de Autores: Creación, edición y eliminación de autores. Un libro puede tener múltiples autores.
- Gestión de Libros: Creación, edición y eliminación de libros. Se pueden asignar múltiples autores a un libro.
- Gestión de Préstamos: Creación, edición y eliminación de préstamos. Los préstamos pueden incluir múltiples libros y tienen un estado que puede ser prestado, con multa o finalizado.
- Gestión de Multas: Sistema de multas asociado a los préstamos, que se calcula automáticamente según las reglas establecidas.
- Gestión de Usuarios: Creación, edición y eliminación de usuarios, con distintos tipos de usuarios (docente, administrativo, alumno).
- Detalles de Préstamo y Libro: Registro detallado de los libros prestados y sus respectivos autores.
- Login y Autenticación: Sistema de autenticación para usuarios con diferentes roles y permisos.
- Dashboard: Visualización de estadísticas clave, incluyendo la cantidad total de libros, préstamos, autores y usuarios.
- Reportes: Gráficos de reportes de préstamos realizados durante el año

## Requisitos

- Backend: Laravel 11
- Frontend: Vue 3
- Base de datos: MySQL

## Setup

- Ejecutar el Archivo ``` setup.bat ```

