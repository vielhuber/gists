async sleep(ms) {
	await new Promise((resolve) => setTimeout(() => resolve(), ms));
}

async foo() {
  	/* ...*/
 	await sleep(1000);
  	/* ...*/
}