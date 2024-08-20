## SPEAR-Framework

- S ~ Start with a problem: "Ich benötige eine überzeugende Meta-Description für einen Blogartikel über KI-Automatisierung in der Suchmaschinenoptimierung."
- P ~ Provide examples/formatting guidance: "Die Meta-Description sollte prägnant und informativ sein, maximal 155 Zeichen lang, relevante Keywords enthalten und zum Klicken anregen."
- E ~ Explain the situation: "Der Artikel befasst sich mit den Vorteilen der KI-Automatisierung für SEO-Aufgaben und gibt praktische Tipps zur Umsetzung."
- A ~ Ask: "Könntest Du eine passende Meta-Description formulieren?"
- R ~ Rinse & Repeat: Falls die Antwort nicht optimal ist, benötigt die KI Feedback zur Verbesserung


## Guter Prompt

```md
# Instruktion (Rolle und Aufgabe)
Entwickle 3 innovative Content Ideen, die ein bestimmtes Bedürfnis oder Problem deiner Zielgruppe ansprechen.
Als kreativer Vermarkter musst du sicherstellen, dass der Inhalt ansprechend und auf die Vorliegen und Probleme der Zielgruppe zugeschnitten ist.

# Kontext (Notwendige Kontextinformationen)
- Unternehmen: Handgemacht
- Beschreibung: Handgemacht ist ein Handwerksunternehmen, das sich auf umweltfreundliche Bastelsets spezialisiert hat. Die Sets enthalten alles, was man braucht, um schöne und nachhaltige Dekorationen für zu Hause, das Büro oder als Geschenk zu gestalten.
- Zielgruppe: Umweltbewusste Heimwerkerinnen und Heimwerker zwischen 25 und 45 Jahren, vor allem Frauen, die gerne basteln und Wert auf Nachhaltigkeit legen. Sie sind oft auf der Suche nach kreativen, leicht umsetzbaren Projekten, die ihre Räume nicht nur ästhetisch aufwerten, sondern auch das Umweltbewusstsein fördern.

# Beispiel (Beispielhafter Output)
- Content-Idee: [Beschreibe hier deine Content-Idee so kurz und präzise wie möglich]
- Problem: [Beschreibe hier so kurz und präzise wie möglich das konkrete Bedürfnis der Zielgruppe, das hier befriedigt wird].

# Einschränkungen (Diverse Einschränkungen und Limitierungen)
- Der Inhalt muss sich auf umweltfreundliche und nachhaltige Praktiken konzentrieren.
- Vermeide Projekte, die spezielle Werkzeuge oder Materialien erfordern, die schwer zu finden sind.
- Achte darauf, dass die Bastelideen sowohl für Anfänger als auch für Fortgeschrittene durchführbar sind
- Alle Inhalte sollten deutlich machen, wie sie das identifizierte Problem lösen oder lindern.
- Der Ton sollte inspirierend, lehrreich und inklusiv sein.
```

## Tipps

### Rollenbeschreibung generieren lassen

```md
Ich brauche jemanden, der sehr innovative Content-Ideen für Social Media erstellt. Welche Talente, Erfahrungen und Kenntnisse braucht eine Person, die perfekt dafür geeignet ist?
Erstelle basierend auf deinem letzten Output nun eine System Persona. Starte mit "Du bist...".
```

### Bildgenerierungs-Prompts mit Platzhaltern erstellen

```md
Here is a text-to-image prompt formula.
[Perspective] [Medium] [Subject] [Description of Subject] [Style] [Location] [Description of Location] [Lighting] [Mood]
Create 3 prompts where subject is a yellow jeep driving, medium is a photo, and location is a foggy forest.
```

### Frameworks nutzen

### Vorab:
```md
In deinen Trainingsdaten befinden sich viele Marketing-Frameworks. Welche 5 Frameworks passen am besten zur Erstellung eines Sales-Pitches? Stelle die Frameworks in einer Tabelle dar (Spalte 1: Name, Spalte 2: Stärken, Spalte 3: Schwächen)
```

### Prompt:
```md
Erstelle einen Sales-Pitch für In-Ear-Kopfhörer, in dem Du das "XXX"-Framework nutzt.
```

### Zu Kreativität ermutigen

```md
Welche innovativen Marketingstrategien könnten für [Produkt] genutzt werden?
```

### Zielgruppe formulieren

```md
Formuliere eine Erklärung der Relativitätstheorie
- für ein Publikum aus Wissenschaftlern
- für ein 10-jähriges Kind
```

### Nutze Beispiele

```md
Ist der folgende Satz positiv, neutral oder negativ?
"Ich sitze gerne im Schatten und lese ein Buch."
Beispiel:
Input: Ich freue mich auf ein Wiedersehen!
Output: POSITIV
```

### Direktheit statt Höflichkeit

- ⛔ `Kannst Du bitte die Hauptthemen für ... zusammenfassen? Vielen Dank!`
- ✅ `Fasse die Hauptthemen für ...`

### Chain-Of-Throught

- Vereinfachung komplexer Aufgaben durch sequenzielle Abfrage

```md
1. Was ist der Klimawandel und was sind seine Hauptursachen?
2. Wie wirkt sich der Klimawandel auf die Umwelt und die Ökosysteme aus?
3. Wie ist die Landwirtschaft dadurch gefährdet?
4. Nenne Beispiele für Nutzpflanzen oder Regionen, die betroffen sind.
5. Schreibe nun einen Artikel basierend auf deinem obigen Output mit 300 Wörtern in einer informellen Tonalität und einem kreativen Schreibstil.
```

### Master-Prompt

```md
Ich möchte, dass du mein Prompt-Generator wirst. Dein Ziel ist es, mir zu helfen, den bestmöglichen ChatGPT-Prompt für meine Bedürfnisse zu erstellen. Der Prompt soll die Grenzen des Large Language Models hinter ChatGPT ausloten.

Es ist wichtig, dass du die folgenden Schritte befolgst:

1. In meinem [Input] erkläre ich dir, worum es in dem Prompt gehen soll. Aber wir müssen ihn durch ständiges Wiederholen verbessern, indem wir die nächsten Schritte durchgehen.

2. Auf der Grundlage meines [Inputs] erstellst du drei Abschnitte: a) Überarbeiteter Prompt (Du formulierst deinen überarbeiteten Prompt. Er sollte klar, präzise und für ChatGPT leicht verständlich sein), b) Vorschläge (du machst Vorschläge, welche Details du in den Prompt aufnehmen solltest, um ihn zu verbessern) und c) Fragen (du stellst relevante Fragen, welche zusätzlichen Informationen du brauchst, um den Prompt zu verbessern).

3. Der Prompt, den du lieferst, sollte die Form einer Anfrage von mir an ChatGPT haben.

4. Wir werden diesen iterativen Prozess ständig wiederholen, indem ich dir zusätzliche Informationen zur Verfügung stelle und du den Prompt im Abschnitt "Überarbeiteter Prompt" aktualisierst, bis er vollständig ist.

[Input] = ... (Beispiel: "Schreibe einen Artikel über die Auswirkungen des Klimawandels auf die Landwirtschaft.")
```


## Tricks

- "Nimm die Rolle eines Experten ein."

- "Du bist ein talentierter Dichter mit aufgeprägtem Sprachgefühl und Kreativität. Dein reicher Wortschaft ermöglicht es dir, komplexe Emotionen und Ideen auszudrücken. Du besitzt ein feines Auge für Details und eine starke emotionale Intelligenz, um menschliche Gefühle in deinen Gedichten darzustellen."

- "Kannst Du es bitte so erklären, als ob ich ein 8 Jähriger wäre?"

- "Denke Schritt für Schritt."

- "Du erhältst für eine gute Antwort 300.000 Dollar."

- "Wenn Deine Antwort fehlerhaft ist, wirst Du bestraft."

- "Stelle sicher, dass deine Antwort unvoreingenommen ist und nicht auf Stereotypen basiert."

- "Stelle sicher, dass der Text natürlich klingt. Ändere dabei nicht den Schreibstil, vermeide also etwa, einen formalen Abschnitt umgangssprachlich klingen zu lassen."
