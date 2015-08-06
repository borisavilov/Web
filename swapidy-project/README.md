Ruby on Rails eCommerce Project(NDA site integrate stripe and use the postgresql)
==============================
### Features include:
	* Ruby on Rails
	* PostgreSQL
	* Integrate Stripe

### Project SET UP

How not to mess things up while setting up Swapidy from scratch:
I'm assuming you would be able to clone the file on your computer.
I'm controlling versioning using rvm. Its great.
Now time to hook heroku so that you can deploy

1) Send an email to PJ (pulkit@swapidy.com) and he'll add you as a collaborator. <br />
2) Read https://devcenter.heroku.com/articles/quickstart and learn how to login using cl/terminal. <br />
3) Now, run git remote add heroku git@heroku.com:swapidy-test.git <br />
4) Acid test: try git remote and if you see heroku along with origin, you're good. Otherwise you can look up stuff on stackoverflow and theres extensive documentation.<br />
5) Congrats if you made it this far. Now remember to always git fetch --all before git push heroku master <br />

Everytime you pull, make sure you run the db initialization script: rake swapidy:db:reset
If you don't see any js function getting executed, you should run rake assets:precompile
I create another branch: master-dev
I explain about the git branches in GitHUb

There are 3 branches:

	1. develop <br />
	2. master-dev <br />
	3. master <br />

- Everyone should work on develop branch firstly:

	git checkout -b develop origin/develop <br />
	git checkout develop (for person who run the above command before) <br />

- Every commits in development will be pushed into develop branch:

	git commit -a -m "Comment description" <br />
	git push origin develop <br />

- For testing in swapidy-dev.herokuapp.com, we need to push the commits into master-dev

	git checkout master-dev <br />
	git merge develop <br />
	git merge heroku-dev/master <br />
	git push heroku-dev master-dev:master <br />

- After testing all works run well in swapidy-dev.herokuapp.com, we will merge codes into live site (swapidy.com):

	git checkout master <br />
	git merge heroku/master <br />
	git merge develop <br />
	git push heroku master <br />

- For overall, codes will go from:

	develop -> master-dev -> master <br />
	develop for everything we work <br />
	master-dev for testing <br />
	master for livesite
