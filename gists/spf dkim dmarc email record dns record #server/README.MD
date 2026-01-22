# SPF

## TL;DR

```v=spf1 a mx ?all```

## ALLGEMEIN

- Der SPF-Record ist ein simpler DNS-Record vom Typ TXT (bei All inkl: TXT (SPF)) für die Hauptdomain `tld.com`
- Es handelt sich um die Möglichkeit, die Autorität eines E-Mail-Absenders zu verifizieren
- Hier wird grob verglichen, ob die IP der Domain des Absenders mit der IP des zu versendenden MX-Servers übereinstimmt
- SPF ist kein Standard: Große Unternehmen wie 1und1 setzen SPF standardmäßig, aber sehr viele Hoster tun das nicht
- Man kann aber eigene SPF Records auch bei kleineren Hostern setzen
- Achtung: SPF verträgt sich nicht gut mit Weiterleitungen.
  - Beispiel: Sender #A sendet an ein E-Mail-Weiterleitungs-Postfach, dieses leitet an Empfänger #A die E-Mail 1:1 weiter (der Absender der E-Mail lautet weiterhin Sender #A!)
  - Ist nun bei Sender #A ein SPF-Record hinterlegt, lehnt Empfänger #A die E-Mail komplett ab (bei -) oder verschiebt sie in den Spam-Ordner
  - Deshalb ist es generell zu empfehlen, das Flag "?" zu setzen
- Bindet man Exchange Online an eine Domain an, die bei einem anderen Provider liegt, empfiehlt Microsoft den SPF-Record `v=spf1 include:spf.protection.outlook.com include:spf.crsend.com -all`
- DomainFactory empfiehlt für ganz normale Postfächer sowie für HostedExchange den Eintrag ```v=spf1 mx a include:ispgateway.de ~all```

## LINKS

- https://mxtoolbox.com/spf.aspx : Test
- https://all-inkl.com/wichtig/anleitungen/kas/tools/dns-werkzeuge/spf_482.html?suche=spf&textsuche=ja : Anleitung bei All Inkl
- https://www.spf-record.de/ : Generator

# DKIM

## ALLGEMEIN

- DKIM beteht aus zwei Hauptbestandteilen: einem DNS-Eintrag sowie dem DKIM-Header, der an alle E-Mails von der Domain angehängt werden muss
- DKIM verwendet digitale Signaturverfahren auf der Grundlage der Public Key-Kryptographie
- Deshalb ist eine Implementierung / Verwendung in E-Mail-Clients eher schwierig
- Newsletteranbieter jedoch fügen den DKIM-Header (bei korrekter Konfiguration) automatisch hinzu

## LINKS

- https://www.cloudflare.com/de-de/learning/dns/dns-records/dns-dkim-record/ : Anleitung

# DMARC

## TL;DR

```v=DMARC1; p=none; pct=100```

## ALLGEMEIN

- Der DMARC-Record ist ein simpler DNS-Record vom Typ TXT für die Subdomain `_dmarc.tld.com`
- Es handelt sich um die Möglichkeit, per Richtlinie anzugeben, was passiert, wenn SPF/DKIM verletzt sind und wie dann E-Mail-Nachrichten behandelt werden
- Man kann DMARC auch ohne DKIM und nur mit SPF einrichten

## LINKS

- https://dmarcian.com/dmarc-record-wizard/ : Generator
- https://www.ionos.de/hilfe/domains/mailserver-und-verwandte-records-konfigurieren/dmarc-record-fuer-eine-domain-konfigurieren/ : Anleitung