~~(Math.random()*(y-x+1))+x

Explanation:
- Math.random(): [0, 1)
- Math.random()*(y-x+1): [0, y-x+1)
- (Math.random()*(y-x+1))+x: [x, y+1)                      
- ~~(Math.random()*(y-x+1))+x: [x, y]