function onOpen(e)
{
  SpreadsheetApp.getActiveSpreadsheet().addMenu('Datei einfügen', [{name: 'Upload', functionName: 'doGet'}]);
}
function doGet(e)
{
  var app = UiApp.createApplication().setTitle('Datei in Sheet hochladen');
  SpreadsheetApp.getActiveSpreadsheet().show(app);
  var form = app.createFormPanel().setId('frm').setEncoding('multipart/form-data');
  var formContent = app.createVerticalPanel();
  form.add(formContent);  
  formContent.add(app.createFileUpload().setName('thefile'));
  formContent.add(app.createHidden("activeCell", SpreadsheetApp.getActiveRange().getA1Notation()));
  formContent.add(app.createHidden("activeSheet", SpreadsheetApp.getActiveSheet().getName()));
  formContent.add(app.createHidden("activeSpreadsheet", SpreadsheetApp.getActiveSpreadsheet().getId()));
  formContent.add(app.createSubmitButton('Jetzt hochladen'));
  app.add(form);
  SpreadsheetApp.getActiveSpreadsheet().show(app);
  return app;
}

function doPost(e)
{
  if( e.parameter.thefile == null )
  {
    return; 
  }  
  var app = UiApp.getActiveApplication();
  app.createLabel('Speichere...');
  var fileBlob = e.parameter.thefile;
  var doc = DriveApp.getFolderById('1foGlTiDJh6qNk8f4BzpsC56Sc99fjBWk').createFile(fileBlob);
  var value = 'hyperlink("' + doc.getUrl() + '";"hier")'
  var activeSpreadsheet = e.parameter.activeSpreadsheet;
  var activeSheet = e.parameter.activeSheet;
  var activeCell = e.parameter.activeCell;
  var label = app.createLabel('Datei erfolgreich hochgeladen');
  app.add(label);
  SpreadsheetApp.openById(activeSpreadsheet).getSheetByName(activeSheet).getRange(activeCell).setFormula(value);
  app.close();
  return app;
}