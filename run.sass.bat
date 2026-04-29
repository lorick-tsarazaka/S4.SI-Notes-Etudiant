@echo off
cd /d %~dp0
sass --watch public/scss/style.scss:public/css/style.css
pause
