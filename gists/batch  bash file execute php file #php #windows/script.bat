REM variant 1: change to dir of php script (and change back afterwards)
@echo off
REM save current dir
set OLDDIR=%CD%
REM change to script dir
@cd /d "%~dp0"
php script.php %*
REM change back
chdir /d %OLDDIR%

REM variant 2
@echo off
php %~dp0/script.php %*