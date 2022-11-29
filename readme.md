# Install and configure Rick and Morty project

### Download the directory
Run a `composer install`


### Create your own copy of the .end file
Rename it to `.env.local`

* https://symfony.com/doc/current/configuration.html

Configure your `.env.local` file, example for mariadb 10.3.25:

```bash
DATABASE_URL="mysql://user-identification:user-login@127.0.0.1:3306/rick-et-morty?serverVersion=mariadb-10.3.25&charset=utf8mb4"
```

### Creating the database
```bash
php bin/console doctrine:database:create
```

### Creating the SQL injection

```bash
php bin/console make:migration
```

### We send on the SQL injection in database

```bash
php bin/console doctrine:migrations:migrate
```

### Checking the connection to the database

```bash
php bin/console doctrine:schema:validate
```

### Load the fixtures in database

```bash
php bin/console doctrine:fixtures:load
```

### Launch a server and test

```bash
php -S 0.0.0.0:8080 -t public
```

Thanks to the api 
* https://rickandmortyapi.com/