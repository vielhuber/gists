Consider I have 4 tables

- persons
- companies
- groups

and

- bills

Now there is a many-to-many relationship between bills/persons and bills/companies and bills/groups.

I see 4 possibilities for a sql schema for this:

### variant 1 (multiple relationship tables)

- persons_bills
  - person_id
  - bill_id
- companies_bills
  - company_id
  - bill_id
- groups_bills
  - group_id
  - bill_id

### variant 2 (one relationship table with one id set and all others null)

- bills_relations
  - person_id
  - company_id
  - group_id
  - bill_id

with a check that only person_id OR company_id OR group_id can be set and all other twos are null.

### variant 3 (one relationship table with string reference to the other table)

- bills_relations 
  - bill_id
  - row_id
  - row_table

with row_table can have the string values 'person', 'company', 'group'.

### variant 4 (add a supertype table)

- persons
  - id
  - debtor_id
- companies
  - id
  - deptor_id
- groups
  - id
  - deptor_id
- deptors
  - id
- bills_deptors
  - bill_id
  - deptor_id

### possible answer

- I think that either variant 1 (multiple relationship tables) or variant 4 (add a supertype table) are the most feasible choices here.
- Variant 2 is a much less efficient way to store the data since it requires the storage of 3 extra NULLs for each relationship.
- Variant 3 will get you into a lot of trouble when trying to JOIN between bills and one of the other tables, since you won't be able to do it directly. You'll have to first select the table name from the string reference, and then inject it into a second query. Any kind of SQL injections like this open up the database to a SQL injection attack, so they are best avoided if possible.
- Variant 1 is probably the best out of 1 and 4 in my opinion, since it will require one less JOIN in your queries and hence make them a little simpler. If all the tables are indexed correctly though, I don't think there should be much difference in performance (or space efficiency) between these two.
