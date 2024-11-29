// overwrite
let console_backup = console;
console = {
    log: msg => {},
    info: msg => {},
    warn: msg => {
        // only show specific errors
        if (msg !== 'hide this specific warning') {
            console_backup.warn(e);
        }
    },
    error: msg => {
        // always show errors
        console_backup.error(msg);
    }
};

// external function that produces warnings you want to suppress
fun();

// reset
console = console_backup;