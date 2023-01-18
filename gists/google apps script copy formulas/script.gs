function copyFormulas()
{  
  var sheets = SpreadsheetApp.getActiveSpreadsheet().getSheets();
  for(var i = 0; i < sheets.length; i++)
  {
    var row = sheets[i].getRange(2, 1, 1, sheets[i].getMaxColumns()).getFormulas();
    for(j = 0; j < row[0].toString().length; j++)
    {      
      if(row[0][j] === undefined || row[0][j].substring(0, 1) !== '=' || row[0][j].indexOf('ARRAYFORMULA') > -1)
      {
       continue;
      }
      sheets[i].getRange(2, 1+j, 1, 1).copyTo( sheets[i].getRange(3, 1+j, sheets[i].getMaxRows(), 1) );
    }
  }
}