
@echo off

FOR /F "usebackq tokens=1-4 delims=/ " %%i in (`echo %date%`) do (
set jour=%%i
set mois=%%j
set annee=%%k
)

set nom_fichier=UniFox-temp_%annee%-%mois%-%jour%


"%ProgramFiles%\7-Zip\7z.exe" a -tzip %nom_fichier%.xpi * -r -mx=9 -xr!.svn -x!*.bat -x!*.xpi

