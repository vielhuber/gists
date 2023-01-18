/* before */
fn() {
  return new Promise((resolve) => {
    	setTimeout(() => {
          	resolve();
        },1000);
  });
}
/* after */
async fn() {
	await new Promise((resolve) => setTimeout(() => resolve(), 1000));
}