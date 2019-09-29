// make two sheets, one "INPUT" and one "_LOGIC"
// in INPUT.col1 make a classical data validation for _LOGIC.col1
// the validation for INPUT.col2 is automatically generated via the following script
function onEdit() {
  DYNAMIC_DROPDOWN('INPUT', 1, '_PROJEKTE');
}
function DYNAMIC_DROPDOWN(sheet_name, sheet_col, sheet_logic) {
  var ss = SpreadsheetApp.getActiveSpreadsheet(),
      sheet = ss.getActiveSheet(),
      range = sheet.getActiveRange(),
      col = range.getColumn(); 
  if(col != sheet_col || sheet.getName() != sheet_name) { return; }
  var row = range.getRow(),
      val = range.getValue();
  if(row < 2) { return; }
  if(val !== null && val != '')
  {
    var logic = ss.getSheetByName(sheet_logic),
        data = logic.getRange(1, 1, logic.getLastRow(), 4).getValues(),
        list = [];
    for(var data_row = 0; data_row < data.length; data_row++) {
    for(var data_col = 0; data_col < data[data_row].length; data_col++) {
      if( data[data_row][0] != '' && data[data_row][3] == 'ja' && data[data_row][1] == val && list.indexOf(data[data_row][0]+': '+data[data_row][2]) === -1 ) { list.push(data[data_row][0]+': '+data[data_row][2]); }
    }
    }
    list.push('Sonderaufwände');
    var rule = SpreadsheetApp.newDataValidation().requireValueInList(list).build();
    sheet.getRange(row, (sheet_col+1)).setValue('').setDataValidation(rule);
  }
  else {
    sheet.getRange(row, (sheet_col+1)).clearContent().clearDataValidations();
  }
}
