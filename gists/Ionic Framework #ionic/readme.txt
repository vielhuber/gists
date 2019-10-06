# install environment
// install node.js for windows (lts, not bleeding edge)
// update npm
// cmd as admin
cd C:\Program Files\nodejs
npm install npm@latest
npm update npm@latest
node -v
npm -v

# install/update ionic
npm install -g ionic
npm update -g ionic

# install/update cordova
npm install -g cordova
npm update -g cordova

# disable telemetry data
cordova -v
"n"

# install/update latest app-scripts (build process)
npm install @ionic/app-scripts@latest --save-dev

# check versions
ionic info

# choose again ip adress after first setup
ionic address

# avast firewall: allow localhost
business.avast.com > Netzwerk > Einstellungen > Windows Workstation > Firewall > anpassen > TODO(!)

# init project
# switch to cmd in ADMINISTRATOR mode (important)
cd C:\MAMP\htdocs\
ionic start my_project blank --v2      // blank template will be used
# other possibilities (not relevant)
ionic start my_project --v2            // tabs template will be used
ionic start my_project tutorial --v2   // tutorial template will be used
ionic start my_project --v2 --ts       // typescript is used by default, so the parameter is not needed
ionic start my_project super --v2      // super template (boilerplate)

# if an error occurs ("npminstall"), simply try again (without administrator)

# switch back to default user mode
cd my_project

# add platforms
ionic platform add android
ionic platform add ios

# serve project
ionic serve
ionic serve -l                        // multi device mode (lab)

# run in emulator
ionic emulate android
ionic emulate ios

# build apk
ionic build android
ionic build ios

# run on connected device
ionic run android
ionic run ios

# upload to ionic.io to preview with Ionic View
ionic upload             // login with credentials


# event, when view is loaded
ionViewDidLoad() {
  console.log('loaded');
}