## WebbyLab Films

#### Installation
- Install php, mysql and pdo-mysql:

    `sudo apt-get install php libapache2-mod-php mysql-server php-pdo-mysql`

#### Configuration
- Clone the repository using HTTPS:

    `git clone https://github.com/tigrisko98/webbylab-films.git`

- Switch to the project's directory:

    `cd webbylab-films`

- Create database and films table using this command:

    `sudo mysql -uroot < webbylab_films_db_dump.sql`

- Change `user` and `password` options in `config/db_params.php` file (optional). 

- Run PHP server on available port:

    `php -S localhost:8080`

- Open `http://localhost:8080/` in browser.
