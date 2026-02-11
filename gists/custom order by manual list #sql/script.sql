SELECT * FROM table ORDER BY col = 'listitem1' DESC, col = 'listitem2' DESC, col = 'listitem3' DESC, col = 'listitem4' DESC;
SELECT * FROM table ORDER BY col LIKE '%listitem1%' DESC, col LIKE '%listitem2%' DESC, col LIKE '%listitem3%' DESC, col LIKE '%listitem4%' DESC;
SELECT * FROM table ORDER BY FIELD(col,'listitem1','listitem2','listitem3','listitem4'); // mysql