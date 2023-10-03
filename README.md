# Accessment

# How you will be assessed

- Tasks are completed to the best of your ability
- Code structure and quality
- Code scalability and performance considerations
- Clear instructions on how to run the application
- Suggest any future improvements you would make if you had unlimited time

# The Test

- Given a CSV file 
- Make a simple web-based interface which:
    - Accepts the CSV file
    - Imports the CSV file into a database
    - Displays the list of Employees
    - allows the user to edit an Employee’s Email Address
    - Shows the average salary of each company

# Bonus

- Add Unit test(s)
- Use Docker

# Docker Configuration
This project will install 3 Docker Container
1.  web - run backend application which is using PHP8.2, It uses port `8000` by default
2.  vue_app_dev - run the frontend application which is written by VUE, It uses port `8080` by default
3.  db - contain the MySQL Database instance, Port `3306` by default

## Things to improve
1.  improve frontend layout
2.  validate CSV file format -> company name, employee name, email address salary must no empty
3.  Email address validation
4.  Validate salary value -> must be a number
5.  make all functions non-static
6.  make Company/Employee properties private and create get(), set() to retrieve or set property
7.  Implement more Unit Tests, especially test on the API functions (get.php and post.php)
8.  Consider security issue on get.php and post.php.  i.e. CSP
9.  Add csrf token when submit csv file


## Installation
1.  Clone this Git repository
2.  Install Docker if not already installed

## Start Docker container
Run `docker-compose up --build -d` to start the docker container.  

If you are starting the docker for the first time
Run `docker-compose exec web sh -c "composer i"` to install PHPUnit by Composer

After the Docker container, please give a couple of seconds for  Apache and MySQL Database instance to start 

## Open the Employee Applicaion
1.  Open `http://localhost:8080 with Chrome and start using the application
2.  Select `employee.csv` and submit to see the result

## Run Unit Test
Run `docker-compose exec web sh -c "php vendor/bin/phpunit ./tests/Test.php"` to run PHPUnit tests in a Docker container

## Stop Docker conatienr
Run `docker-composer down` to stop the docker container

