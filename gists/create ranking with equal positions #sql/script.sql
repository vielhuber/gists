CREATE TABLE
    user(id INT, score INT);
INSERT INTO
    user(id, score)
VALUES
    (1, 10), (2, 40), (3, 55), (4, 10), (5, 5), (6, 20), (7, 30), (8, 70), (9, 30);

SET @score_prev = NULL;
SET @cur_rank = 0;
SELECT id, score, CASE
    WHEN @score_prev = score THEN @cur_rank
    WHEN @score_prev := score THEN @cur_rank := @cur_rank + 1
END AS rank
FROM user
ORDER BY score DESC;