## Unsortierte Notizen

- Vorsehen von Textalternativen für alle Nicht-Textinhalte (wichtigste Bilder)
- Verbergen / Kennzeichnen dekorativer Grafiken
- Alternativen zu grafischen Captchas
- HTML-Auszeichnung spiegelt logische Struktur des Dokuments wieder
- Seite ist ohne CSS in logischer Reihenfolge
- Textgrößenänderungsfunktion
- Erreichbarkeit von allen relevanten Seitenfunktion per Tabulator
- Formular-Eingabefelder hat korrekte Fokus-Reihenfolge
- Deutliche Hervorhebung der aktuellen Fokus-Stelle
- Vollständige Auszeichnung des HTML-Quellcodes durch ARIA (Accessible Rich Internet Applications)
- Tests mit web.dev/Lighthouse, Chrome Developer Tools, NVDA, WAVE, Color Contrast Accessibility Validator, HeadingsMap, ChromeLens
- css outline: none geht gar nicht => Ersetzen durch Lösung wie Smashing Magazine
- WICG inert: mark parts of the page as "absent" from the page: Menu if open: NOT inert; if closed: inert
- replace div with button/a tags
- aria-hidden="true"
- aria-label="Open Menu"
- tab-index und bei unfokussierten Dingen tab-index="-1"
- focus() Management via javascript (durchführen durch App)
- div => headings wie h1 / html5 main
- <div id="header"> => <header> (html5)
- Developer Tools: axe coconut / Chrome Lighthouse
- High Contrast: Color Picker Chrome Extension (AA, AAA)
- Integration accessibility test: Selenium + AxeBuilder

 ## Links
  - https://a11ywins.tumblr.com/
  - https://www.heise.de/select/ct/2022/14/2212312480213805889
  - https://www.heise.de/select/ct/2022/15/2215314242196328845