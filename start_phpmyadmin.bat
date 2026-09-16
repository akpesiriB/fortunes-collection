@echo off
title Fortunes Collection - phpMyAdmin & SQL Manager
cd /d "%~dp0"

echo ===================================================
echo   FORTUNES COLLECTION - PHPMYADMIN & SQL MANAGER
echo ===================================================
echo.

:: 1. Check if MySQL/MariaDB is running on port 3306
netstat -ano | findstr :3306 >nul
if %errorlevel% neq 0 (
    echo [INFO] MariaDB/SQL is not running. Starting MySQL server...
    start "MariaDB SQL Server" /B "C:\mariadb\bin\mysqld.exe" --defaults-file="C:\mariadb\my.ini" --console
    timeout /t 3 /nobreak >nul
) else (
    echo [OK] MySQL/MariaDB is already running on port 3306.
)

echo.
echo [INFO] Launching phpMyAdmin on http://localhost:8085 ...
echo Direct phpMyAdmin: http://localhost:8085/index.php?route=/database/structure&db=fortunes_collection
echo Integrated Atelier: http://localhost:8000/phpmyadmin/index.php?route=/database/structure&db=fortunes_collection
echo Database Name: fortunes_collection
echo.

:: 2. Launch browser to fortunes_collection in phpMyAdmin
start "" "http://localhost:8085/index.php?route=/database/structure&db=fortunes_collection"

:: 3. Run php built-in server for phpMyAdmin
"C:\php\php.exe" -S localhost:8085 -t "%~dp0public\phpmyadmin"
pause
