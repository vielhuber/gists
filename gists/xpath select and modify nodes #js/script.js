let nodes = document.evaluate(
  '/html/body//*[contains(concat(" ", normalize-space(@class), " "), " container ")]//text()[normalize-space()]',
  document,
  null,
  XPathResult.ORDERED_NODE_SNAPSHOT_TYPE,
  null
);
for (let i = 0; i < nodes.snapshotLength; i++) {
	nodes.snapshotItem(i).textContent = 'FOO';
}