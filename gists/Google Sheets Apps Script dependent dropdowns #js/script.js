// make two sheets, one "INPUT" and one "_LOGIC"
// in INPUT.col1 make a classical data validation for _LOGIC.col1
// the validation for INPUT.col2 is automatically generated via the following script
function onEdit() {
  DYNAMIC_DROPDOWN('INPUT', 1, '_PROJEKTE');
}

function DYNAMIC_DROPDOWN(sheet_name, sheet_col, sheet_logic) {
    var ss = SpreadsheetApp.getActiveSpreadsheet(),
        sheet = ss.getActiveSheet(),
        range = sheet.getActiveRange();
    if (sheet.getName() != sheet_name) {
        return;
    }
    for (var col = range.getColumn(); col <= range.getLastColumn(); col++) {
        for (var row = range.getRow(); row <= range.getLastRow(); row++) {
            if (col != sheet_col || row < 2) {
                continue;
            }
            var col_rel = col - range.getColumn() + 1,
                row_rel = row - range.getRow() + 1,
                val = range.getCell(row_rel, col_rel).getValue();
            if (val !== null && val != '') {
                var logic = ss.getSheetByName(sheet_logic),
                    data = logic.getRange(1, 1, logic.getLastRow(), 4).getValues(),
                    list = [];
                for (var data_row = 0; data_row < data.length; data_row++) {
                    if (
                        data[data_row][0] != '' &&
                        data[data_row][0] != '#ERROR!' &&
                        data[data_row][0] != ' ' &&
                        data[data_row][1] == val &&
                        list.indexOf(data[data_row][0] + ': ' + data[data_row][2]) === -1
                    ) {
                        list.push(data[data_row][0] + ': ' + data[data_row][2]);
                    }
                }
                list.push('Sonderaufwände');
                var rule = SpreadsheetApp.newDataValidation()
                    .requireValueInList(list)
                    .setAllowInvalid(false)
                    .build();
                // set rule only if data validation is already present
                if (
                    sheet.getRange(row, sheet_col + 1).getDataValidation() === null ||
                    JSON.stringify(
                        sheet
                            .getRange(row, sheet_col + 1)
                            .getDataValidation()
                            .getCriteriaValues()
                    ) != JSON.stringify(rule.getCriteriaValues())
                ) {
                    sheet
                        .getRange(row, sheet_col + 1)
                        .setValue('')
                        .setDataValidation(rule);
                }
            } else {
                sheet
                    .getRange(row, sheet_col + 1)
                    .clearContent()
                    .clearDataValidations();
            }
        }
    }
}
