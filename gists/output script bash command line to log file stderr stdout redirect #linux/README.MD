| syntax | example | terminal: StdOut | terminal: StdErr | file: StdOut | file: StdErr | type |
|--------|---------|------------------|------------------|--------------|--------------|------|
| * | `command` | ☑️ | ☑️ | ⛔ | ⛔ | overwrite |
| | | | | | | |
| > | `command > output.log` | ⛔ | ☑️ | ☑️ | ⛔ | overwrite |
| >> | `command >> output.log` | ⛔ | ☑️ | ☑️ | ⛔ | append |
| | | | | | | |
| 2> | `command 2> output.log` | ☑️ | ⛔ | ⛔ | ☑️ | overwrite |
| 2>> | `command 2>> output.log` | ☑️ | ⛔ | ⛔ | ☑️ | append |
| | | | | | | |
| &> | `command &> output.log` | ⛔ | ⛔ | ☑️ | ☑️ | overwrite |
| &>> | `command &>> output.log` | ⛔ | ⛔ | ☑️ | ☑️ | append |
| | | | | | | |
| \| tee | `command \| tee output.log` | ☑️ | ☑️ | ☑️ | ⛔ | overwrite |
| \| tee -a | `command \| tee -a output.log` | ☑️ | ☑️ | ☑️ | ⛔ | append |
| | | | | | | |
| \|& tee | `command \|& tee output.log` | ☑️ | ☑️ | ☑️ | ☑️ | overwrite |
| \|& tee -a | `command \|& tee -a output.log` | ☑️ | ☑️ | ☑️ | ☑️ | append |