## debounce

- debounce a function when you want it to execute only once after a defined interval of time
- if the event occurs multiple times within the interval, the interval is reset each time

**example: a user typing into an input continuously for 30s every 0.5s leads to 1 event for a debounce of 1s.**

## throttle

- throttle a function when you want it to execute periodically with an interval in between each execution
- if the event occurs multiple times within the interval, the interval is not reset each time

**example: a user typing into a field continuously for 30s every 0.5s leads to 15 events for a throttle of 1s.**