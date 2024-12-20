# Introduction
This project provides an application with tools to
- calculate electricity bill before it's received from your vendor
- get totalprices for next hours
- calculate price for certain, inputted data today
- get data about electriciy installation, charges, etc.

Data is retrieved from multiple sources:
- Eloverblik
- EnergiDataService
- Smart-Me

## Based on Laravel 10

# Installation
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

if you get bind problems for e.g. tcp4 0.0.0.0:80 (http) or tcp4 0.0.0.0:3306 (mysql), you can change the forward ports in .env like these examples:
```.dotenv
APP_PORT=8001
FORWARD_DB_PORT=3308
```

## Generate a new App Key
```bash
sail artisan key:generate
```

## Migrate
```bash
sail artisan migrate
```

## Passport
```bash
sail artisan passport:install
```

## Build NPM & Vite components

```bash
sail npm install
sail npm run build 
```

## Now is a good time to view all the nice stuff
Navigate to http://localhost/ (if you set the APP_PORT, you should include this in link also, e.g.: http://localhost:8001 )

### Data
Want some data to get things going?
Populate with prices might be an idea - this also loads grid operators:
#### Charge groups
```bash
sail artisan energidata:request-and-store-charge-groups
```
#### Prices (may take a while - expect ~75min.)
(tip, import csv database/fixtures/poweruse_datahub_price_lists.csv to table instead ("Remove problematic data" step won't be necessary if you do so))
```bash
sail artisan energidata:request-and-store-datahub-prices
```

#### Remove problematic data
```bash
sail artisan datahubpricelist:remove-problematic-data
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

## PWA
The appilication is provided as PWA (https://developer.mozilla.org/en-US/docs/Web/Progressive_web_apps)
Icons for the PWA isn't imported and rendered through vite as one might expect. This is due to fact, that the technology
doesn't seem mature enough at point of implementing to be able to handle icon-assets in manifest.
Service worker registration is performed in app.js while all configuration is kept in vite.config.js
Be careful if changing paths/urls as errors might not show immediately and can seem a bit tricky since module is doing a
lot of *magic!* and adds sub-directories to path-strings.

## Mails
When developing locally we use Mailhog to trap all mails.

The interface is available here:
http://localhost:8025/
