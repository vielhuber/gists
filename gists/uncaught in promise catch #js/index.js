function test() {
    return new Promise((resolve,reject) => { 
      	reject();
    });
}

// sometimes we want to react on errors
test().then(() => { }).catch(() => { });

// sometimes we don't
test() // this causes an error on chrome (uncaught in promise)

// solution 1 (simple)
test().catch(()=>{});
// solution 2 (helper function)
function t(fn) { fn().catch(()=>{}); }
t(test());
// solution 3 (especially good for multiple times calling test());
(async () => { try { await test();await test();await test(); } catch(e) { console.log(e); } })();
