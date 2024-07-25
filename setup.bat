@echo off

:: Cambiar al directorio api y ejecutar comandos necesarios
cd C:\Users\5kyf4ll\Downloads\tecweb-main\api
echo Configurando backend...

:: Instalar dependencias de Composer
call composer install

:: Renombrar .env.example a .env
rename .env.example .env

:: Generar clave de aplicación
call php artisan key:generate

:: Ejecutar migraciones y semillas, aceptando automáticamente la creación de la base de datos
echo yes | php artisan migrate --force
echo yes | php artisan db:seed --force

:: Abrir una nueva ventana de CMD para ejecutar el servidor de Laravel
start cmd /k "cd C:\Users\5kyf4ll\Downloads\tecweb-main\api && php artisan serve"

:: Cambiar al directorio app y ejecutar comandos necesarios
cd C:\Users\5kyf4ll\Downloads\tecweb-main\app
echo Configurando frontend...
call npm install
call npm run dev

:: Regresar al directorio original
cd C:\Users\5kyf4ll\Downloads\tecweb-main

echo Configuración completada. Se han iniciado dos ventanas de CMD para el servidor backend y el frontend.
pause
