### setup

consider 3 tables

- **humans**
- **cats**
- **dogs**

and another table

- **examinations**

an examination can possibly be of a human xor of a cat xor of a dog.

the following three variants are in my opinion all possible:

## variant 1 (leave it inside one table)

**examinations**

- id
- ...
- human_id
- cat_id
- dog_id

+ check constraints/triggers that only one of these three values can be null

## variant 2 (create relation tables)

**humans_examinations**

- id
- human_id
- examination_id

**cats_examinations**

- id
- cat_id
- examination_id

**dogs_examinations**

- id
- dog_id
- examination_id

## variant 3 (create a supertype)

**patients**

- id
- ... (possible other common fields of human/cat/dog)

**human**

- id
- ...
- patient_id

**cat**

- id
- ...
- patient_id

**dog**

- id
- ...
- patient_id

**examinations**

- id
- ...
- patient_id