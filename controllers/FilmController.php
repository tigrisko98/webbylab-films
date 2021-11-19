<?php

class FilmController
{
    private $formats = ['DVD', 'VHS', 'Blu-Ray'];

    public function actionCreate(): bool
    {
        $film = new Film();
        $filmsList = $film->getFilmsListWithoutLimit();
        $formatsList = $this->actionFormats();

        if (!isset($_POST['format'])) {
            $_POST['format'] = '';
        }

        if (isset($_POST['submit'])) {
            foreach ($_POST as $value) {
                $value = htmlspecialchars($value);
            }
            $errors = Validator::validateFilm($_POST, $filmsList);
            if (empty($errors)) {
                $film->createFilm($_POST);

                echo '<script>setTimeout(function () {
                    window.location.href = "/";  }, 2000);</script>';
            }
        }

        require_once(ROOT . '/views/film/create.php');
        return true;
    }

    public function actionImport(): bool
    {
        $films = new Film();
        $filmsList = $films->getFilmsListWithoutLimit();

        if (isset($_POST['submit'])) {
            $importFile = $_FILES;
            $errors = Validator::validateImportFile($importFile, $filmsList);

            if (empty($errors)) {
                if (Parser::getFileExtension($importFile) == 'csv') {
                    $parsedFile = Parser::parseCsvFile($importFile);
                    unset($parsedFile[0]);
                } elseif (Parser::getFileExtension($importFile) == 'txt' || Parser::getFileExtension($importFile) == 'docx') {
                    $parsedFile = Parser::parseTxtOrDocFile($importFile);
                }

                $executeQuery = $films->batchInsert($parsedFile);

                if ($executeQuery !== true) {
                    $errors[] = 'Invalid file.';
                } else {
                    echo '<script>setTimeout(function () {
                    window.location.href = "/";  }, 2000);</script>';
                }
            }
        }

        require_once(ROOT . '/views/film/import.php');
        return true;
    }

    public function actionUpdate($id): bool
    {
        $film = new Film();
        $filmsList = $film->getFilmsListWithoutLimit();
        $filmData = $film->getFilmById($id);
        $formatsList = $this->actionFormats();

        if (!isset($_POST['format'])) {
            $_POST['format'] = $filmData['format'];
        }

        if (isset($_POST['submit'])) {
            foreach ($_POST as $value) {
                $value = htmlspecialchars($value);
            }
            $errors = Validator::validateFilm($_POST, $filmsList);
            if (empty($errors)) {
                $film->updateFilmById($id, $_POST);
                echo '<script>setTimeout(function () {
                    window.location.href = "/";  }, 2000);</script>';
            }
        }

        require_once(ROOT . '/views/film/update.php');
        return true;
    }

    public function actionDelete($id): bool
    {
        $film = new Film();
        $filmData = $film->getFilmById($id);

        if (isset($_POST['submit'])) {
            $result = $film->deleteFilmById($id);
            header("Location: /");
        }
        require_once(ROOT . '/views/film/delete.php');
        return true;
    }

    public function actionView($id): bool
    {
        $film = new Film();
        $filmData = $film->getFilmById($id);

        require_once(ROOT . '/views/film/view.php');
        return true;
    }

    public function actionFormats(): array
    {
        return $this->formats;
    }
}