# TransferGO Test API

## 1. Getting started
- Download this repository
- Set up `.env` file based on `.env.example` in main directory
- Set up `.env` and `.env.test` files based on `.env.example` and `.env.test.example` in `src/` directory
- Run `docker-compose up --build` in main project directory (where docker-compose.yml is)
- Wait until docker install and deploy the application, you should see `ready to handle connections` at the end

## 2. Accessing container and tests
- Run `docker ps` and see under what name container php-fpm is running
- Access the container with `docker exec -it {container_name} bash`
- Run `php bin/console doctrine:database:create --env=test` to create database for tests
- Run `php bin/console doctrine:migrations:migrate --env=test --no-interaction` to create database structure
- Run `php bin/phpunit` to run tests

## 3. Accessing APIs
### By generated frontend
- Open your browser on [http://localhost:8080/api/doc](http://localhost:8080/api/doc)
- Use method by expanding them and clicking "Try it out"
- You can edit and try different parameters and payloads

### By external program (like Postman)
- Use OpenApi 3.0 specification available on [http://localhost:8080/api/doc.json](http://localhost:8080/api/doc.json)