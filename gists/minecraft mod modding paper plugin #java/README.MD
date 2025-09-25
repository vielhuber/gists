## Setup

- Java
  - Adoptium installieren: https://adoptium.net/en-GB/temurin/releases/?os=windows&package=jdk&version=21
  - Version: 21
  - Set JAVA_HOME environment variable: Ja
  - Test: `java -version`
- Intellij IDEA Community
  - Einstellungen
    - Plugins > "Deutsch (German) Language Localization" (kostenlose Version)
    - Appearance > Languages > German > Restart
    - Plugins > "Minecraft Development"
    - Editor > Inspektionen > Korrekturlesen > Deaktivieren
    - Editor > Unambiguous Imports währenddessen hinzufügen: an
    - Werkzeuge > Aktionen beim Speichern > Code neu formatieren + Importe optimieren
  - Neues Projekt
    - Projektname: "test"
    - Speicherort: ~\Minecraft
    - Plugin + Paper + Gradle + Java
    - Minecraft Version: 1.21.8
    - Group ID: me.david
    - JDK: 21 (nochmal danach ggf: "SDK einrichten:")
- Lokalen Server aufsetzen
  - Paper downloaden auf https://papermc.io/downloads/paper
  - *.jar kopieren in ~\Minecraft\paper\paper.jar
  - java -Xms4G -Xmx4G -jar paper.jar --nogui
  - eula.txt: eula=true
  - In Vanilla Minecraft connecten zu "localhost"
- Production-Server aufsetzen
  - Server bei https://mine-hoster.de buchen
  - Administration: https://gamepanel.mine-hoster.de
  - Versionen > Paper > Neueste Version
- Rechte geben
  - `/op rebuhleiv` in der Server-Konsole
  - Schreibt auch gleich die `ops.json` richtig
  - Test mit `/time set day`
- Build (lokal + production)
  - Gradle > Tasks > build > build
  - /test/build/libs/\*.jar kopieren in /plugins
    - `cp '/mnt/c/Users/David/Minecraft/test/build/libs/test-1.0-SNAPSHOT.jar' '/mnt/c/Users/David/Minecraft/paper/plugins/test-1.0-SNAPSHOT.jar'`
  - Server sauber neustarten (nicht `/reload`)
  
## Server-Label

- Name: Server properties > motd (Generator: https://minecraft.tools/de/motd.php)
- Icon: `/server-icon.png` (64x64) in Root-Verzeichnis legen
- Domain: A-Record auf IP-Adresse zeigen

## Resource Pack

- `cd ./resourcepack/data`
- `rm ./../data.zip && zip ./../data.zip -r . && sha1sum ./../data.zip`
- Uploaden und `server.properties` editieren (siehe git)
- Lokaler Ordner: `%APPDATA%\Roaming\.minecraft\downloads\`
- Logs: `%APPDATA%\Roaming\.minecraft\logs\latest.log`
- Resource Pack Refresh: F3+T
- Gerenderte Texturen: F3+S: .minecraft/screenshots/debug

## Simple Voice Chat

- Serverseitig in `/plugins` instalieren
- https://modrinth.com/plugin/simple-voice-chat/versions?g=1.21.8&l=paper
- Clientseitig z.B. mit `CurseForge` installieren

## Links

- https://www.youtube.com/watch?v=ZzdIm5uuHCk
- https://docs.fabricmc.net/players/installing-java/windows

## Code

- Link auf Boilerplate