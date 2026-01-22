let nodes = [],
	treeWalker = document.createTreeWalker(node, NodeFilter.SHOW_COMMENT, null, false),
	currentNode;
while ((currentNode = treeWalker.nextNode())) {
	nodes.push(currentNode);
}
console.log(nodes);