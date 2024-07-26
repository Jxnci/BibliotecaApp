@echo off

:: Ruta al archivo php.ini
set "PHP_INI_PATH=C:\xampp\php\php.ini"

:: Hacer una copia de seguridad del archivo php.ini
copy "%PHP_INI_PATH%" "%PHP_INI_PATH%.bak"

:: Remover el comentario de la extensión zip en php.ini
powershell -Command "(gc '%PHP_INI_PATH%') -replace ';extension=zip', 'extension=zip' | Out-File -encoding ASCII '%PHP_INI_PATH%'"

echo La configuración de php.ini ha sido actualizada.

:: Obtener la ruta actual del script
set "BASE_DIR=%~dp0"

:: Crear la base de datos si no existe
echo Creando la base de datos si no existe...
mysql -u root -e "CREATE DATABASE IF NOT EXISTS twf"

:: Cambiar al directorio api y ejecutar comandos necesarios
cd /d "%BASE_DIR%api"
echo Configurando backend...

:: Instalar dependencias de Composer
call composer install

:: Renombrar .env.example a .env
copy .env.example .env

:: Configurar la base de datos en .env
powershell -Command "(gc '.env') -replace 'DB_CONNECTION=sqlite', 'DB_CONNECTION=mysql' | Out-File -encoding ASCII '.env'"
powershell -Command "(gc '.env') -replace 'DB_HOST=127.0.0.1', 'DB_HOST=127.0.0.1' | Out-File -encoding ASCII '.env'"
powershell -Command "(gc '.env') -replace 'DB_PORT=3306', 'DB_PORT=3306' | Out-File -encoding ASCII '.env'"
powershell -Command "(gc '.env') -replace 'DB_DATABASE=twf', 'DB_DATABASE=twf' | Out-File -encoding ASCII '.env'"
powershell -Command "(gc '.env') -replace 'DB_USERNAME=root', 'DB_USERNAME=root' | Out-File -encoding ASCII '.env'"
powershell -Command "(gc '.env') -replace 'DB_PASSWORD=', 'DB_PASSWORD=' | Out-File -encoding ASCII '.env'"

:: Generar clave de aplicación
call php artisan key:generate

:: Ejecutar migraciones y semillas
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
