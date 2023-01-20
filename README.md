# Introduction
<p>It's strongly recommended that you add an alias to your bash/zsh config</p>
<p>It will make it much easier to run the sail command</p>

```bash
alias sail="./vendor/bin/sail"
```

## Install dependencies
You will have to install dependencies locally, because we use `sail` which is located in the `/vendor` folder.

```bash
composer install --ignore-platform-reqs
```

## Set default environment variables

```bash
cp .env.example .env
```

## Start application

### Docker (might take a while first time)
```bash
sail up -d
```
[if you get "Docker is not running." this link might be helpful](https://docs.docker.com/engine/install/linux-postinstall/)

## Generate a new App Key
```bash
sail artisan key:generate
```

Navigate to http://localhost/

## Passport
```bash
sail artisan passport:install
```

## Migrate

```bash
sail artisan migrate
```

## Build NPM & Vite components

```bash
sail npm run build 
```

## Testing

```bash
sail test
```

## Static analysis
Run the static analysis locally inside the docker container through `sail`

```bash
sail shell ./bin/phpstan
```

## PSR
Run the psr fixer locally inside the docker container through `sail`

```bash
sail shell ./bin/style
```

## Test with code-coverage
You can generate a test coverage report using **XDebug**, which is already preinstalled,
simply by adding `XDEBUG_MODE=coverage` as environment varible.

```bash
XDEBUG_MODE=coverage sail test
```

## Mails
When developing locally we use Mailhog to trap all mails.

The interface is available here:
http://localhost:8025/
