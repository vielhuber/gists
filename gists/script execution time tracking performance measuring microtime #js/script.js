let time = new Date();

for(let i = 0; i < 10000000; i++) {
    ~~(Math.random()*(i-0+1))+0;
}

console.log('script execution time: '+((new Date() - time)/1000) + ' seconds');