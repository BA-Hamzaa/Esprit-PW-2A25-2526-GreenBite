@echo off
echo ================================
echo   NutriGreen - Demarrage serveur
echo ================================
echo.
echo Serveur demarre sur : http://localhost:8000
echo Appuie sur CTRL+C pour arreter
echo.
start http://localhost:8000
C:\xampp\php\php.exe -S localhost:8000 -t "%~dp0app\views\public"
pause
