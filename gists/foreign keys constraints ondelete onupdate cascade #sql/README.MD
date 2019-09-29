"What happens, when a referenced row is deleted, to the main table?"

## ON DELETE
### one way: always use RESTRICT and manage dependencies in your application
### other way: chose behaviour independently for each case and let the db do this logic
- ```ON DELETE NO ACTION```: Default, you cannot delete a referenced row
- ```ON DELETE RESTRICT```: Same as no action, with the difference, that in transactions the script immediately stops
- ```ON DELETE CASCADE```: When a referenced row is deleted, the whole row with the foreign key is also deleted
- ```ON DELETE SET NULL```: When a referenced row is deleted, the column with the reference is set to null
- ```ON DELETE SET DEFAULT```: When a referenced row is deleted, the column with the reference is set to it's default value

## ON UPDATE
### on update generally does not make any sense when the ids are primary keys that don't change
### it sometimes makes sense when a special case applies (when the id is a product nr that changes)
- ```ON UPDATE NO ACTION```: Default, you cannot update the id of a referenced row
- ```ON UPDATE RESTRICT```: Same as no action, with the difference, that in transactions the script immediately stops
- ```ON UPDATE CASCADE```: When a referenced rows id is updated, the row with the foreign key is also updated
- ```ON UPDATE SET NULL```: When a referenced rows id is updated, the column with the reference is set to null
- ```ON UPDATE SET DEFAULT```: When a referenced rows id is updated, the column with the reference is set to it's default value