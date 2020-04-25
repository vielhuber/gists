#### problem: match the shortest possible string where we know start and end

- ```this start bar start foo end this```

### try #1
```start.*end```

=> ```start bar start foo end```

(does not work)


### try #2

```start.*?end```

=> ```start bar start foo end```

(does not work, because non-greedy operator ? acts left to right, not right to left)

### try #3

```start((?!start).)*end```

=> ```start foo end```

(works)