# TransferGO Test API

## 1. Getting started
- Download this repository
- Set up `.env` file based on `.env.example` in main directory
- Set up `.env` and `.env.test` files based on `.env.example` and `.env.test.example` in `src/` directory
- Currently predefined services are:
  - Twilio SMS: https://www.twilio.com/
  - SMSAPI: https://www.smsapi.com/en
- You can later install and configure any other SMS providers from https://symfony.com/doc/current/notifier.html#sms-channel
- Run `docker-compose up --build` in main project directory (where docker-compose.yml is)
- Wait until docker install and deploy the application, you should see `ready to handle connections` at the end

## 2. Accessing container
- Run `docker ps` and see under what name container php-fpm is running
- Access the container with `docker exec -it {container_name} bash`

## 3. Running consumer
- Inside container run `php bin/console messenger:consume notification` to start rabbit consumer

## 4. User throttling settings
- In `.env` you can find configuration for user throttling:
  - `USER_THROTTLE_HOURS` - how many hours back is checked for user message count
  - `USER_THROTTLE_LIMIT` - limit of messages sent to user

## 5. Tests
- Run `php bin/console doctrine:database:create --env=test` to create database for tests
- Run `php bin/console doctrine:migrations:migrate --env=test --no-interaction` to create database structure
- Run `php bin/phpunit` to run tests

## 6. Accessing APIs
### By generated frontend
- Open your browser on [http://localhost:8080/api/doc](http://localhost:8080/api/doc)
- Use method by expanding them and clicking "Try it out"
- You can edit and try different parameters and payloads

### By external program (like Postman)
- Use OpenApi 3.0 specification available on [http://localhost:8080/api/doc.json](http://localhost:8080/api/doc.json)

## 7. What's next?
Stuff to improve with more time:
- move Doctrine operations to Command and Queries
- expand basic tests
- add email services abstraction
- refactor structure to DDD
