## EMPFOHLENER WERT

```v=spf1 a mx ?all```

## ALLGEMEIN

- Der SPF-Record ist ein simpler DNS-Record vom Typ TXT (bei All inkl: TXT (SPF))
- Es handelt sich um die Möglichkeit, die Autorität eines E-Mail-Absenders zu verifizieren
- Hier wird grob verglichen, ob die IP der Domain des Absenders mit der IP des zu versendenden MX-Servers übereinstimmt
- SPF ist kein Standard: Große Unternehmen wie 1und1 setzen SPF standardmäßig, aber sehr viele Hoster tun das nicht
- Man kann aber eigene SPF Records auch bei kleineren Hostern setzen
- Achtung: SPF verträgt sich nicht gut mit Weiterleitungen.
  - Beispiel: Sender #A sendet an ein E-Mail-Weiterleitungs-Postfach, dieses leitet an Empfänger #A die E-Mail 1:1 weiter (der Absender der E-Mail lautet weitrhin Sender #A!)
  - Ist nun bei Sender #A ein SPF-Record hinterlegt, lehnt Empfänger #A die E-Mail komplett ab (bei -) oder verschiebt sie in den Spam-Ordner
  - Deshalb ist es generell zu empfehlen, das Flag "?" zu setzen

## LINKS

- https://all-inkl.com/wichtig/anleitungen/kas/tools/dns-werkzeuge/spf_482.html?suche=spf&textsuche=ja : Anleitung bei All Inkl
- https://www.spf-record.de/ : Sehr guter Generator
