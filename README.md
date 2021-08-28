
# Starter project for Polly

This is a starter project for Polly and implemented some basic examples, among other things, of authentication, authorization, translation, localization, logging and ORM.
Everything is overridable and is not neccessary to use, but it provides an example of how the framework works and how things can be implemented.
> ***A starter project for what?? Polly?? Whats that??***

<p>Polly is a lightweight PHP framework for PHP > 8.0. The framework is focussed on helping developers with a reliable expandable architecture, implementing cross cutting concerns and handling key aspect implementations. The main goal is to achieve this in a lightweight way and keep maximum flexibility.</p>
 
All the documentation of how Polly works and how to use it can be found in the [Polly Framework repository](https://github.com/stefanpols/polly-framework).


# Installation & Configuration
Follow the steps below to setup the starter project.

### Setup project
Create a project folder in your workspace and run:<br/>`git clone https://github.com/stefanpols/polly-project-starter.git .`

### Install dependencies
Navigate to your project and run `composer install`

### Prepare database
Create a database and import the pre-generated SQL files:<br/>

    [YOUR_PROJECT_FOLDER]/generate/generated/session.sql
    [YOUR_PROJECT_FOLDER]/generate/generated/user.sql

Polly doesn't support auto generating relations yet, so you have to create the foreign relation yourself:

	ALTER TABLE `session` ADD FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

Create your first user in table `user`. Example SQL for user: `example@user.com / example`
```SQL
INSERT INTO `user` (`user_id`, `firstname`, `lastname`, `username`, `password`, `created`, `active`) VALUES ('13e6756b-0726-11ec-bbd8-00d86109062e', 'Example', 'User', 'example@user.com', '$2y$10$WygahOMsIJ8n1fqCJxwJA.ULJR3LjW1ds/Sn920oaifdabpnjIdPi', '2021-01-01 12:00:00', '1');`
```
> TIP: Use [phppasswordhash](https://phppasswordhash.com/) to generate password

### Prepare project
Modify the `.env` file to your project specifications:<br />
`DEBUG` Whenever debug is enabled or not. 0 = Disabled, 1 = Enabled. Exceptions will be shown when debug is enabled.<br />
`VERSION` The current version number of the app. Is used, among other things, for asset versions.<br />
`APP_URL` = The base URL of the system endpoint, e.g. "https://www.example.com". <br />
`API_URL` = (optionel) The base url of the API endpoint, e.g. "https://api.example.com".<br />
`DB_HOST` = The hostname of the database server, e.g. "127.0.0.1"<br />
`DB_PORT` = The database port to use, e.g. "3306".<br />
`DB_DATABASE` = The name of the default database to use.<br />
`DB_USERNAME` = The username of the database user.<br />
`DB_PASSWORD` = The password of the database user.<br />

Apart from these variables you can add as many variables as you want. They can be accessed by `Polly\Core\App::environment($value, $fallback)`

# Creating your app

After setup you can go to your defined `APP_URL` and login with the first created user.
The core architecture of Polly consists of 4 layers:
- Presentation (Controller/View)
- Service layer
- Repository layer
- Model layer

The starter project provides the `polly-generator` tool to create a basic class for these layers. Use the command below in de CLI from the project's root directory, where {ENTITY} is de name of a file (**without extension**) located in the `generate` folder. In this folder you will find two examples (`user` and `session`) which are already created in this project. Be carefull with executing the `polly-generator` on these, since it overrides everything.

    php polly-generator --entity {ENTITY}

The generator creates minimal classes of `model`, `service`, `repository`, `controller` and an index view.
It also generates a SQL file for the given entity in `generate\generated\{ENTITY}.sql`. The SQL contains the basic structure of the defined properties. Relations and constraints need to be added manually in SQL.
