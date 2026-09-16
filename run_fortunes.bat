@echo off
title Fortunes Collection - Platform Runner
cd /d "%~dp0"

echo ===================================================
echo       FORTUNES COLLECTION - PLATFORM RUNNER
echo ===================================================
echo.

:: 1. Ensure SQL server is running
netstat -ano | findstr :3306 >nul
if %errorlevel% neq 0 (
    echo [INFO] Starting MySQL server...
    start "MariaDB SQL Server" /B "C:\mariadb\bin\mysqld.exe" --defaults-file="C:\mariadb\my.ini" --console
    timeout /t 3 /nobreak >nul
) else (
    echo [OK] MySQL is active on port 3306.
)

echo.
echo Launching Fortunes Atelier & Admin Command Center...
echo Public Storefront: http://localhost:8000
echo Admin Command:     http://localhost:8000/admin/login
echo phpMyAdmin (SQL):  http://localhost:8000/phpmyadmin/index.php?route=/database/structure&db=fortunes_collection
echo Dedicated PMA:     http://localhost:8085 (via start_phpmyadmin.bat)
echo.

start http://localhost:8000
"C:\php\php.exe" artisan serve --host=127.0.0.1 --port=8000
pause
