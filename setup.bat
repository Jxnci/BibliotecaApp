@echo off

:: Obtener la ruta actual del script
set "BASE_DIR=%~dp0"

:: Cambiar al directorio api y ejecutar comandos necesarios
cd /d "%BASE_DIR%api"
echo Configurando backend...

:: Instalar dependencias de Composer
call composer install

:: Renombrar .env.example a .env
rename .env.example .env

:: Generar clave de aplicación
call php artisan key:generate

:: Crear base de datos si no existe y ejecutar migraciones y semillas
if not exist database\database.sqlite (
    echo Creando base de datos SQLite...
    type NUL > database\database.sqlite
)
call php artisan migrate --force
call php artisan db:seed --force

:: Abrir una nueva ventana de CMD para ejecutar el servidor de Laravel
start cmd /k "cd /d %BASE_DIR%api && php artisan serve"

:: Cambiar al directorio app y ejecutar comandos necesarios
cd /d "%BASE_DIR%app"
echo Configurando frontend...
call npm install
call npm run dev

:: Regresar al directorio original
cd /d "%BASE_DIR%"

echo Configuración completada. Se han iniciado dos ventanas de CMD para el servidor backend y el frontend.
pause
