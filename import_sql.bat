@echo off
title Fortunes Collection - Import SQL Database
cd /d "%~dp0"

echo ===================================================
echo   FORTUNES COLLECTION - IMPORT SQL DATABASE
echo ===================================================
echo.

:: 1. Ensure SQL server is running
netstat -ano | findstr :3306 >nul
if %errorlevel% neq 0 (
    echo [INFO] Starting MySQL server...
    start "MariaDB SQL Server" /B "C:\mariadb\bin\mysqld.exe" --defaults-file="C:\mariadb\my.ini" --console
    timeout /t 3 /nobreak >nul
)

echo [INFO] Importing fortunes_collection.sql into MariaDB/MySQL...
"C:\mariadb\bin\mysql.exe" -u root -e "CREATE DATABASE IF NOT EXISTS fortunes_collection CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
"C:\mariadb\bin\mysql.exe" -u root fortunes_collection < "%~dp0fortunes_collection.sql"

if %errorlevel% equ 0 (
    echo.
    echo [SUCCESS] Database fortunes_collection imported successfully!
    echo All 38 tables and seed records are now active.
) else (
    echo.
    echo [ERROR] An error occurred while importing SQL file.
)

echo.
pause
