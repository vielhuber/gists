# login
npm login
# create a normal github repo
# ...
# get the current version
git describe --tags
# first publish to npm (do not create an auto git tag, because we want to do that manually)
npm --no-git-tag-version version 1.0.0
npm publish
# make changes and push new version
git add -A .; git commit -m ""; git push origin master
git tag -m "" -a 1.0.0
git push --tags

# oneliner
npm --no-git-tag-version version 1.0.0 && npm publish && gitu "pushed" && git tag -m "" -a 1.0.0 && git push --tags