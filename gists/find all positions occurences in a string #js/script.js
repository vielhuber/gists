function findAllPositions(searchStr, str)
{
  let searchStrLen = searchStr.length,
      startIndex = 0,
      index,
      indices = [];
  if(searchStrLen == 0)
  {
    return [];
  }
  while((index = str.indexOf(searchStr, startIndex)) > -1)
  {
    indices.push(index);
    startIndex = index + searchStrLen;
  }
  return indices;
}
findAllPositions('foo', 'this is a foo and a foobar');