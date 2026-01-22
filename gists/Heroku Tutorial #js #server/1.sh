mkdir vielhuber-casperjs-test
cd vielhuber-casperjs-test
git init
heroku apps:create vielhuber-casperjs-test --region eu --stack cedar --buildpack https://github.com/heroku/heroku-buildpack-nodejs.git