## WebbyLab Films

#### Installation
- Install php, mysql and pdo_mysql:

    `sudo apt-get install php libapache2-mod-php mysql-server pdo_mysql`

#### Configuration
- Switch to the project's directory:

    `cd webbylab_films`

- Create database and films table using this command:

    `sudo mysql -uuser -ppassword < webbylab_films_db_dump.sql`

- Run PHP server on available port:

    `php -S localhost:8080

- Open `http://localhost:8080/` on browser.
