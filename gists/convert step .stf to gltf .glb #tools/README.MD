#### download cad exchanger
- https://cadexchanger.com/download/
- or from "SETUP\CAD Exchanger\cadexchanger_3.7.0_build11852_win64.msi"

#### copy evaluation license
- copy "SETUP\CAD Exchanger\cadex_license.lic" to "C:\Program Files\CAD Exchanger\bin"

#### windows time
- reset windows time `to 22.11.2019`

#### run from command line to recursively convert all files
```
for /R %f in (*.stp) do "C:\Program Files\CAD Exchanger\bin\ExchangerConv.exe" -i "%f" -e "%~dpnf.glb"
```