SERVER

- Download > SoftEther VPN (Freeware) > SoftEther VPN Server
- Installation (normal)
- Start SoftEther VPN Server Manager
- Connect (localhost)
- Password: vpn
- Easy Setup: Close
- Do you want to set up IPsec: No
- IPsec / L2TP Setting
- Enable L2TP Server Functino (L2TP over IPsec)
- IPsec Pre-Shared Key: vpn
- DEFAULT: Manage Virtual Hub
- Manage Users
- User Name: vpntest
- Password: vpn
- Enable traffic routing now
- Virtual NAT and Virtual DHCP Server (SecureNAT) > Enable SecureNAT > Yes

ROUTER
- Freigabe der UDP Ports 500 und 4500

CLIENT
- Windows > VPN
- IP-Adresse: Öffentliche IPv4 oder alternativ vpnXXXXXXXXX.softether.net (zu finden in SoftEther)
- VPN-Typ: L2TP/IPsec mit vorinstalliertem Schlüssel
- Schlüssel: vpn
- Anmeldeinformationstyp: Benutzername und Kennwort
- Benutzername: vpntest
- Passwort: vpn