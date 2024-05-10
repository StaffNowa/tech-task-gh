# How to run the project
1. Download Docker for Symfony https://github.com/StaffNowa/docker-symfony/releases (the latest version v2.0.21)
2. Extract tar xzfv d4d_darwin_all.tar.gz
3. Create a project directory inside the docker project.
4. Go to the directory project and clone the Symfony project.
5. Start the project with the command ./d4d start
6. After start containers run command ./d4d exec php
7. Run doctrine migration via command line php bin/console doctrine:migrations:migrate --no-interaction

## Flight list
http://symfony.local/flights/list

### Add flight (POST method)
http://symfony.local/flights/add

Request example:
`{"flightNumber": "test", "flightDate": "2024-05-11"}`

### Flight arrival
http://symfony.local/flights/flight-arrival/BT341/2024-05-11

## Ground crew member list
http://symfony.local/ground-crew-members/list

### Add ground crew member (POST method)
http://symfony.local/ground-crew-members/add

Request example:
`{"name": "test"}`

## Certification list
http://symfony.local/certifications/list

### Add certification (POST method)
Request example:
`{"name": "test", "validFrom": "2024-05-01", "validUntil": "2024-05-31"}`

## Skill list
http://symfony.local/skills/list

### Add skill (POST method)
http://symfony.local/skills/add

Request example:
`{"name": "test"}`


## Task list
http://symfony.local/tasks/list

### Add task (POST method)
http://symfony.local/tasks/add

Request example:
`{"name": "test", "flightId": 1}`

### Task complete
http://symfony.local/tasks/complete-task/31

# Compose features

## How to run php-cs-fixer:
1. Inside project run command ./d4d exec php
2. Run command composer php-cs