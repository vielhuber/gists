### sender
- Verwalten Sie Windows-Anmeldeinformationen
- Windows-Anmeldeinformationen hinzufügen
- Host: CUSTOM-PC
- Benutzername: CustomName
- Passwort: ***

### sender + receiver
- regedit: HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet\Control\Terminal Server\AllowRemoteRPC auf 1 setzen
- restart

### sender
- batch script on desktop
```
@ECHO OFF
echo Nachricht eingeben!
set /p MSG= 
msg * /SERVER:CUSTOM-PC CustomName /W "%MSG%"
```