function init() {
    CREATERESTRICTEDSHEETS([
        ['user1@tld.com', 'MAX MUSTERMANN', 'SHEETNAME', ['B', 'C', 'D'], "Col1 = 'max'"],
        ['user2@tld.com', 'ERIKA MUSTERMANN', 'SHEETNAME', ['B', 'C', 'D'], "Col1 = 'erika'"]
    ]);
}

function CREATERESTRICTEDSHEETS(data) {
    var master_sheet = SpreadsheetApp.getActiveSpreadsheet(),
        master_file = DriveApp.getFileById(master_sheet.getId()),
        master_folders = master_file.getParents(),
        master_folder = null,
        existing_files = [],
        existing_files_iterator = null;

    // determine current folder
    while (master_folders.hasNext()) {
        master_folder = master_folders.next();
    }
    // determine existing files
    existing_files_iterator = master_folder.getFiles();
    while (existing_files_iterator.hasNext()) {
        existing_files.push(existing_files_iterator.next());
    }

    // be aware: this sets your master sheet to public (only when link is known)
    // this is needed to overcome the need for manually accepting permissions for importrange
    // see: https://stackoverflow.com/a/32474761/2068362
    master_file.setSharing(DriveApp.Access.ANYONE_WITH_LINK, DriveApp.Permission.VIEW);

    // loop through users
    for (var data__key = 0; data__key < data.length; data__key++) {
        // determine new sheet name
        var copy_name = master_file.getName() + ' - ' + data[data__key][1];

        // delete potentially existing files
        for (
            var existing_files__key = 0;
            existing_files__key < existing_files.length;
            existing_files__key++
        ) {
            if (existing_files[existing_files__key].getName() === copy_name) {
                existing_files[existing_files__key].setTrashed(true);
            }
        }

        // copy file
        var copy_file = DriveApp.getFileById(master_sheet.getId()).makeCopy(
                copy_name,
                master_folder
            ),
            copy_spreadsheet = SpreadsheetApp.openById(copy_file.getId()),
            copy_sheets = copy_spreadsheet.getSheets(),
            copy_sheet = copy_spreadsheet.getSheetByName(data[data__key][2]);

        // delete all other sheets in this spreadsheet
        for (var copy_sheets__key = 0; copy_sheets__key < copy_sheets.length; copy_sheets__key++) {
            if (copy_sheets[copy_sheets__key].getName() !== data[data__key][2]) {
                copy_spreadsheet.deleteSheet(copy_sheets[copy_sheets__key]);
            }
        }

        // clear content (and remain format)
        copy_sheet.clearContents();

        // determine shown columns
        var copy_shown_cols = [],
            copy_labels = [],
            copy_last_col_index = copy_sheet.getMaxColumns(),
            copy_last_col_letter = copy_sheet
                .getRange(1, copy_last_col_index, 1, 1)
                .getA1Notation()
                .match(/([A-Z]+)/)[0];
        for (
            var copy_cur_col_index = 1;
            copy_cur_col_index <= copy_last_col_index;
            copy_cur_col_index++
        ) {
            var copy_cur_col_letter = copy_sheet
                .getRange(1, copy_cur_col_index, 1, 1)
                .getA1Notation()
                .match(/([A-Z]+)/)[0];
            if (data[data__key][3].indexOf(copy_cur_col_letter) > -1) {
                var copy_placeholder = '';
                for (
                    var copy_tmp_col_index = 1;
                    copy_tmp_col_index <= copy_cur_col_index;
                    copy_tmp_col_index++
                ) {
                    copy_placeholder += ' ';
                }
                copy_shown_cols.push("'" + copy_placeholder + "'");
                copy_labels.push("'" + copy_placeholder + "' ''");
                copy_sheet.hideColumns(copy_cur_col_index);
            } else {
                copy_shown_cols.push('Col' + copy_cur_col_index);
            }
        }

        // determine conditions
        var query_condition = '';
        if (data[data__key][4] !== undefined) {
            query_condition += ' WHERE ' + data[data__key][4];
        }

        // finally set formula
        var query_formula =
            '=QUERY(IMPORTRANGE("' +
            master_sheet.getId() +
            '";"' +
            data[data__key][2] +
            '!A1:' +
            copy_last_col_letter +
            '"); "SELECT ' +
            (data[data__key][3].length > 0 ? copy_shown_cols.join(', ') : '*') +
            query_condition +
            '' +
            (copy_labels.length > 0 ? ' LABEL ' + copy_labels.join(', ') : '') +
            '")';
        copy_sheet.getRange('A1').setFormula(query_formula);

        // remove default permissions
        var users = copy_file.getEditors();
        for (var users__key = 0; users__key < users.length; users__key++) {
            copy_spreadsheet.removeEditor(users[users__key]);
        }
        var users = copy_file.getViewers();
        for (var users__key = 0; users__key < users.length; users__key++) {
            copy_spreadsheet.removeViewer(users[users__key]);
        }

        // set same permissions as master sheet
        var users = master_file.getEditors();
        for (var users__key = 0; users__key < users.length; users__key++) {
            copy_spreadsheet.addEditor(users[users__key]);
        }
        var users = master_file.getViewers();
        for (var users__key = 0; users__key < users.length; users__key++) {
            copy_spreadsheet.addViewer(users[users__key]);
        }

        // additionally add specified viewer
        copy_spreadsheet.addViewer(data[data__key][0]);
    }
}
