/* log / debug */
Logger.log('log a string');
Logger.log(['not','possible']);
Logger.log({ trick: ['this','is','possible'] });
SpreadsheetApp.getActiveSpreadsheet().getSheetByName('INPUT').getRange('A10').setValue(JSON.stringify(obj));
console.log{ trick: ['this','is','possible'] }); // this can be accessed in the stackdriver logging engine

/* current oauth token */
ScriptApp.getOAuthToken()

/* current sheet name */
SpreadsheetApp.getActiveDocument().getName()

/* current user email */
Session.getActiveUser()

/* md5 function */
function md5(str)
{
	return Utilities.computeDigest(Utilities.DigestAlgorithm.MD5, str).reduce(function(str,chr){
	chr = (chr < 0 ? chr + 256 : chr).toString(16);
	return str + (chr.length==1?'0':'') + chr;
	},'');
}

/* google docs: get selected text / insert text */
/* https://developers.google.com/apps-script/quickstart/docs */

/* add custom menu */
function onOpen()
{
  SpreadsheetApp.getActiveSpreadsheet().addMenu("CUSTOM", [{name: "LABEL", functionName: "myFunction"}]);
}

/* share scripts across sheets */
/* https://webapps.stackexchange.com/questions/39604/how-to-re-use-google-apps-scripts-in-new-google-spreadsheet/ */

/* get sheet by name */
SpreadsheetApp.getActiveSpreadsheet().getSheetByName('FOO')

/* get value of current cell */
SpreadsheetApp.getActiveSpreadsheet().getActiveSheet().getActiveCell().getValue()

/* get value of current cell */
SpreadsheetApp.getActiveSpreadsheet().getActiveSheet().getActiveRange().getValue()

/* get value of all selected cells (important for multiple selects) */
SpreadsheetApp.getActiveSpreadsheet().getActiveSheet().getActiveRange().getValues()

/* get value of specific cell */
SpreadsheetApp.getActiveSpreadsheet().getSheetByName('FOO').getRange('A1').getValue()

/* set value of specific cell */
SpreadsheetApp.getActiveSpreadsheet().getSheetByName('FOO').getRange('A1').setValue('foo');

/* print array */
SpreadsheetApp.getActiveSpreadsheet().getSheetByName('DEBUG').getRange(1, 1, arr.length, arr[0].length).setValues(data);

/* clear content */
SpreadsheetApp.getActiveSpreadsheet().getSheetByName('DEBUG').getRange(1, 1, 1, 5).clearContent();

/* get formula of specific cell */
SpreadsheetApp.getActiveSpreadsheet().getSheetByName('FOO').getRange('A1').getFormula()

/* set formula of specific cell */
SpreadsheetApp.getActiveSpreadsheet().getSheetByName('FOO').getRange('A1').setFormula('1+2');
SpreadsheetApp.getActiveSpreadsheet().getSheetByName('FOO').getRange('A1').setFormula('IF(1=1;2;3)'); // this is a little bit weird: use english function names, but german separators (;)

/* set background color of specific sell */
SpreadsheetApp.getActiveSpreadsheet().getSheetByName('FOO').getRange('A1').setBackground('#efefef');

/* auto expand rows */
// in the past this has worked in the normal ui (set height manually to 2, then change the option to "auto fit"); now it does not work anymore!
// the following script still works
var s = SpreadsheetApp.getActiveSpreadsheet().getSheetByName('TEST');
s.setRowHeights(1, s.getMaxRows(), 3);

/* protect specific cell */
var protection = e.source.getActiveSheet().getRange(1, 1, 1, 6).protect().setDescription('Nicht mehr änderbar');
var me = Session.getEffectiveUser();
protection.addEditor(me);
protection.removeEditors(protection.getEditors());

/* get all values from sheet */
SpreadsheetApp.getActiveSpreadsheet().getSheetByName('FOO').getDataRange().getValues()

/* get range with indexes */
var s = SpreadsheetApp.getActiveSpreadsheet().getSheetByName('FOO');
s.getRange(1, 1, s.getLastRow(), s.getLastColumn()); // filled sheet
s.getDataRange() // equivalent of above
s.getRange(1, 1, s.getMaxRows(), s.getMaxColumns()); // complete sheet

/* get remote sheet */
SpreadsheetApp.openById('1UmhbdLw1OmEmSxjtT2hKsmsDgExOxMZmeOAL_ChVs_Q').getSheetByName('FOO')

/* loop through all cells in specific sheet */
var data = SpreadsheetApp.getActiveSpreadsheet().getSheetByName('FOO').getDataRange().getValues();
for ( y = 0; y < data.length; y++ ) {
  for ( x = 0; x < data[y].length; x++ ) {
    if( data[y][x] != '' ) {
      data[y][x] += 'foo';
    }
  }
}
SpreadsheetApp.getActiveSpreadsheet().getSheetByName('FOO').getDataRange().setValues(data);

/* copy all content to array */
var data = [],
    sheets = SpreadsheetApp.getActiveSpreadsheet().getSheets();
for(var i = 0; i < sheets.length; i++)
{
  data[sheets[i].getName()] = sheets[i].getDataRange().getValues();
} 
console.log(data);

/* get maximum column index and letter */
var index = SpreadsheetApp.getActiveSpreadsheet().getSheetByName('FOO').getMaxColumns();
var letter = SpreadsheetApp.getActiveSpreadsheet().getSheetByName('FOO').getRange(1, index, 1, 1).getA1Notation().match(/([A-Z]+)/)[0];

/* ask question */
var ui = SpreadsheetApp.getUi();
var response = ui.alert('Bist Du sicher?\n\nOder nicht?', ui.ButtonSet.YES_NO);
if( response == ui.Button.YES )
{
   // ...
}

/* show alert */
SpreadsheetApp.getUi().alert('Hello, world!');

/* get sheet url */
var spreadsheet = SpreadsheetApp.getActiveSpreadsheet(),
	sheet = spreadsheet.getActiveSheet(),
    link = spreadsheet.getUrl() + '#gid=' + sheet.getSheetId();

/* show modal with print link */
var url = 'https://docs.google.com/spreadsheets/d/1TM0kugtYxAoGxS-zqGwTQQ2Oi54czahfKhcCA7_aVDw/export?exportFormat=pdf&amp;format=pdf&amp;format=pdf&amp;size=7&amp;fzr=true&amp;fzc=true&amp;portrait=true&amp;scale=2&amp;spct=1&amp;gridlines=false&amp;printnotes=false&amp;printtitle=false&amp;printdate=false&amp;printtime=false&amp;sheetnames=false&amp;pagenum=undefined&amp;pageorder=2&amp;attachment=true&amp;top_margin=0.39370078740157477&amp;bottom_margin=0&amp;left_margin=0.5905511811023622&amp;right_margin=0.5905511811023622&amp;timestamp=42973.87412068287&amp;horizontal_alignment=CENTER&amp;vertical_alignment=TOP&amp;gridFiltersProto=[]&amp;gid='+SpreadsheetApp.getActiveSpreadsheet().getSheetId();
var html = '<html><body><a href="'+url+'" target="_blank" onclick="google.script.host.close()">Download</a></body></html>';
var ui = HtmlService.createHtmlOutput(html)
SpreadsheetApp.getUi().showModelessDialog(ui,'Dokument ausdrucken');



/* loop through all tabs (sheets) and delete them */
var ss = SpreadsheetApp.getActiveSpreadsheet();
var sheets = ss.getSheets();
for(var i = 0; i < sheets.length ; i++)
{
	var sheet = sheets[i];
	if( sheet.getName() != 'keep' )
	{
		ss.deleteSheet(sheet);
	}
}

/* auto triggers */
function onOpen()
{
	// runs automatically on open without manual trigger
}
function onEdit()
{
	// runs automatically on edit without manual trigger
}
function onEdit(e)
{
   if( e.source.getActiveSheet().getName() !== 'Sheet1' || e.range.rowStart != 2 || e.range.columnStart != 1 ) { return; }
   // runs automatically when editing cell B1 in Sheet1
   console.log(e.range.getValue());
   // also helpful: do something with all selected cells (warning, this does not work for splitted cells like in filter)
   console.log(e.range.getValues());
   for(var col = e.range.columnStart; col <= e.range.columnEnd; col++) {
   	for(var row = e.range.rowStart; row <= e.range.rowEnd; row++) {
      if( col != 2 || row < 2 ) { continue; } // check
    }
   }
   // use this outside of onEdit with any range
   for (var col = range.getColumn(); col <= range.getLastColumn(); col++) {
     for (var row = range.getRow(); row <= range.getLastRow(); row++) {
       if( col != 2 || row < 2 ) { continue; } // check
     }
   }
   // set formula in current cell
  	e.source.getActiveSheet().getRange(e.range.rowStart, e.range.columnStart).setFormula('1+2');
}

/* popup with link */
function onOpen()
{
  var menu = [{name: 'Action', functionName: 'openUrl'}];
  SpreadsheetApp.getActiveSpreadsheet().addMenu('Title', menu);
}

function openUrl()
{
  var html = '<html><body><a href="https://test.de" target="blank" onclick="google.script.host.close()">Description</a></body></html>';
  var ui = HtmlService.createHtmlOutput(html);
  SpreadsheetApp.getUi().showModelessDialog(ui,'Title Action');
}

/* addon menu */
SpreadsheetApp
	.getUi()
	.createAddonMenu()
	.addItem('menuitem1', 'function1')
	.addItem('menuitem2', 'function2')
	.addToUi();


/* http requests */
// note: you cannot use UrlFetchApp with onEdit / onOpen because of missing scopes
// instead use a trigger (rename the function to onEditTrigger and call function via trigger)

// helper
function get(args)
{
	return JSON.parse(UrlFetchApp.fetch('https://www.tld.com/api.php?token='+ScriptApp.getOAuthToken()+'&sheet='+DocumentApp.getActiveDocument().getName()+'&user='+Session.getActiveUser()+'&'+encodeURI(args), {'method': 'get', 'muteHttpExceptions': true}));
}

/* send email */
MailApp.sendEmail({
    to: "foo@tld.com",
    subject: "The subject",
    htmlBody: "Lorem ipsum dolor sit amet."
});
Logger.log("remaining email quota: " + MailApp.getRemainingDailyQuota());
