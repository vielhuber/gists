REM comments
:: comments

REM disable commands
@ECHO OFF

REM clear console
CLS

REM allow variables in for loops
setlocal enabledelayedexpansion
for %%A in (foo bar baz) do (
    SET "TEST=%%A"
    rem echo %TEST%
    echo !TEST!
)

REM set utf8
chcp 65001 >nul

REM I am a comment
mkdir C:\Users\Administrator\Downloads\foo

REM prevent auto close
pause