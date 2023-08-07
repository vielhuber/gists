### checkout pr locally

- `gh pr checkout 16` // 16 is the pr id
- `git merge master` // now do all stuff like normal, e.g. merge current master in branch

### merge pr into master

- `git checkout master`
- `git merge foo/bar`
- `git push`
- the pr then closes automatically