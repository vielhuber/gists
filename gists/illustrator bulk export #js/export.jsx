var sourceDir = 'C:/Users/xxx/Downloads/in/',
    destDir = 'C:/Users/xxx/Downloads/out/',
    tmpFile = 'C:/Users/xxx/Downloads/tmp.svg',
    logFile = 'C:/Users/xxx/Downloads/log.txt',
    actionName = 'Export',
    actionGroup = 'SVG',
    override = false;

try {
    alert('Let\'s go!');
    var sourceFolder = Folder(sourceDir),
        destFolder = Folder(destDir),
        files = getAllFiles(sourceFolder, 'svg'),
        length = files.length;

    uip = app.userInteractionLevel;
    app.userInteractionLevel = UserInteractionLevel.DONTDISPLAYALERTS;
    if (length > 0) {
        for (var i = 0; i < length; i++) {
            /*
            we could use ExportOptionsSVG, but not all options (like responsive or minified are available.
            so we instead we use a different approach with actions
            */
            /*
            var options = new ExportOptionsSVG();
            // https://gist.github.com/iconifyit/2cbab3f0dd421b6d4bb520bfcf445f0d
            */
            if( override === false ) {
                var newFileName = files[i].toString().replace(sourceFolder, destFolder);
                if( (new File(newFileName)).exists ) { log('['+Math.round(i*100/length)+'%] skipping file '+newFileName+'...'); continue; }
            }
            var sourceDoc = app.open(files[i]),
                newFolderPath = sourceDoc.path.toString().replace(sourceFolder, destFolder),
                newFilePath = newFolderPath + '/' + sourceDoc.name,
                tmpFile = new File(tmpFile),
                newFolder = new Folder(newFolderPath);
            if (!newFolder.exists) { newFolder.create(); }
            app.doScript(actionName, actionGroup);
            tmpFile.copy(newFilePath);
            tmpFile.remove();
            sourceDoc.close(SaveOptions.DONOTSAVECHANGES);
            log('['+Math.round(i*100/length)+'%] converted file '+newFilePath+'...'); 
        }
    }
    app.userInteractionLevel = uip;
    alert('42!');
} catch (e) {
    alert(e.message, 'error', true);
}

function getAllFiles(pathToFolder, extensionList) {
    var pathFiles = Folder(pathToFolder).getFiles(),
        files = new Array(),
        subfiles;
    if (extensionList === undefined) {
        extensionList = '';
    } else if (typeof extensionList !== 'function') {
        extensionList = new RegExp('.(' + extensionList.replace(/,/g, '|').replace(/ /g, '') + ')$', 'i');
    }
    for (var i = 0; i < pathFiles.length; i++) {
        if (pathFiles[i] instanceof File) {
            if (pathFiles[i].name.match(extensionList)) {
                files.push(pathFiles[i]);
            }
        } else if (pathFiles[i] instanceof Folder) {
            subfiles = getAllFiles(pathFiles[i], extensionList);
            for (var j = 0; j < subfiles.length; j++) {
                files.push(subfiles[j]);
            }
        }
    }
    return files;
}

function log(input) {
    var now = new Date(),
        output = input,
        logFileObj = File(logFile);
    $.writeln(now.toTimeString() + ': ' + output);
    logFileObj.open('a');
    logFileObj.writeln(now.toTimeString() + ': ' + output);
    logFileObj.close();
}
