## Setup

- Java
  - Adoptium installieren: https://adoptium.net/en-GB/temurin/releases/?os=windows&package=jdk&version=21
  - Version: 21
  - Set JAVA_HOME environment variable: Ja
  - Test: `java -version`
  - Falls das nicht geht: PATH prüfen und alte Einträge entfernen (`which java`)
- Bestehendes Projekt klonen
  - mkdir /mnt/c/Users/David/Minecraft/test
  - cd /mnt/c/Users/David/Minecraft/
  - git clone git@github.com:vielhuber/minecraft.git .
- Neues Projekt anlegen
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
      - Speicherort: %userprofile%/Minecraft
      - Plugin + Paper + Gradle + Java
      - Minecraft Version: 1.21.8
      - Group ID: me.david
      - JDK: 21 (nochmal danach ggf: "SDK einrichten:")
    - Build (lokal + production)
      - Gradle > Tasks > build > build
      - /test/build/libs/\*.jar kopieren in /plugins
      - Server sauber neustarten (nicht `/reload`)
- Lokalen Server aufsetzen
  - Paper downloaden auf https://papermc.io/downloads/paper
  - *.jar kopieren in %userprofile%/Minecraft/paper/paper.jar
  - Start mit `java -Xms4G -Xmx4G -jar paper.jar --nogui`
  - eula.txt bearbeiten: eula=true
  - In Vanilla Minecraft connecten zu "localhost"
  - Upgrade: Einfach neues *.jar downloaden und paper.jar ersetzen
- Production-Server aufsetzen
  - Server bei https://mine-hoster.de buchen
  - Administration: https://gamepanel.mine-hoster.de
  - Versionen > Paper > Neueste Version
- Rechte geben
  - `/op rebuhleiv` in der Server-Konsole
  - Schreibt auch gleich die `ops.json` richtig
  - Test mit `/time set day`
- Minecraft Launcher starten und zu `localhost` verbinden

## Usage

- VSCode zum Editieren öffnen
- Scripte
  - `cd scripts`
  - `script.bat local`
  - `script.bat prod`

### Server-Konfiguration

- Name: Server properties > motd (Generator: https://minecraft.tools/de/motd.php)
- Icon: `/server-icon.png` (64x64) in Root-Verzeichnis legen
- Domain: A-Record von externer Domain auf IP-Adresse zeigen

### Fernzugriff

- server.properties
  - `enable-rcon=true`
  - `rcon.password=foo`
  - `rcon.port=25575`
- mcrcon-0.7.2-windows-x86-64.zip

### Resource Packs

- `cd ./resourcepack/data`
- `rm ./../data.zip`
- `zip ./../data.zip -r .`
- `sha1sum ./../data.zip`
- Uploaden und `server.properties` editieren

```
require-resource-pack=true
resource-pack=https\://tl.com/path/to/data.zip
resource-pack-id=
resource-pack-prompt={"text"\:"Server-Pack für deine Waffen","color"\:"gold"}
resource-pack-sha1=0086e2294ef390c7fddfde527927423fae2075f9
```

- Lokaler Ordner: `%APPDATA%\.minecraft\downloads\`
- Logs: `%APPDATA%\.minecraft\logs\latest.log`
- Resource Pack Refresh: F3+T
- Gerenderte Texturen: F3+S: `%APPDATA%\.minecraft\screenshots\debug\minecraft_textures_atlas_blocks.png_0.png`
- Es geht immer nur ein Resourcepack parallel

### Simple Voice Chat

- Serverseitig in `/plugins` installieren
- https://modrinth.com/plugin/simple-voice-chat/versions?g=1.21.8&l=paper
- Clientseitig z.B. mit `CurseForge` installieren

## Links

- https://www.youtube.com/watch?v=ZzdIm5uuHCk
- https://docs.fabricmc.net/players/installing-java/windows

## Code

- https://github.com/vielhuber/minecraft