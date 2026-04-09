@echo off
echo ================================
echo   NutriGreen - Demarrage serveur
echo ================================
echo.
echo Serveur demarre sur : http://localhost:8000
echo Appuie sur CTRL+C pour arreter
echo.
D:\xampp\php\php.exe -S localhost:8000 -t "%~dp0public"
pause
