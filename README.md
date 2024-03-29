# Bootcamp Newsweek

This project uses docker4drupal, Drupal, npm, Composer.

## Development

### 1. You need to install: [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx), [NPM](https://docs.npmjs.com/cli/v8/commands/npm-install).

### 2. Start project:
- Clone project to local directory:
```
git clone git@github.com:VRiabovol/drupal_project.git
```
- Copy and configure .env file from: 
```
https://github.com/wodby/docker4drupal/blob/master/.env
```
- Run docker containers:
```
docker-compose up -d
```
- From php container run:
```
docker-compose exec php composer install
```
- Deploy the project
```
docker-compose exec php drush deploy
```
- Run in the root of project
```
npm i
```
- Run in the web/themes/custom/mytheme of project
```
npm i
```
```
npm run build
```
```
npm run start
```
