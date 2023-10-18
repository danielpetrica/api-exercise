# APi exercise

## Task instructions and  solution comment 
Please read [exercise_text.md](exercise_text.md)

## First installation 

Use the following command to install the initial vendor requirements

```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```
Start Sail 
```bash
./vendor/bin/sail up -d 
```
To test the project we are using laravel pest. By doing this we can ensure the project works as expected and we don't need to
send the api requests while developing.
We use a dedicated .env.testing file while testing.

## Laravel sail use
We use Laravel sail for the developing environment and for testing. 

Use laravel for all laravel commands and to start the development environment. 

### Start dev environment
```bash
./vendor/bin/sail up -d 
```

### Stop dev environment
```bash 
./vendor/bin/sail down
``` 
### Execute 
```bash
./vendor/bin/sail pest
```

### Execute the test with coverage report 
```bash
./vendor/bin/sail pest --coverage
```
### Execute any artisan command
```bash
./vendor/bin/sail artisan <command>
```
