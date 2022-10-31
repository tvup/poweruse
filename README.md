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

### Docker
```bash
cp .env.docker.example .env
```

### Local development
```bash
cp .env.example .env
```

## Generate a new App Key
```bash
sail artisan key:generate
```

## Start application

### Docker
```bash
sail up -d
```

### Local
```bash
php artisan serve
```

Navigate to http://localhost/

## Migrate

```bash
sail artisan migrate
```

# Testing

```bash
sail test
```

## Test with code-coverage
You can generate a test coverage report using **XDebug**, which is already preinstalled,
simply by adding `XDEBUG_MODE=coverage` as environment varible.

```bash
XDEBUG_MODE=coverage sail test
```
