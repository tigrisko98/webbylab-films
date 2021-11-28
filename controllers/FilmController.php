<?php

class FilmController extends FilmBase
{
    public function actionCreate(): bool
    {
        $filmsList = $this->film->getFilmsListWithoutLimit();
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
                $this->film->createFilm($_POST);

                echo '<script>setTimeout(function () {
                    window.location.href = "/";  }, 2000);</script>';
            }
        }

        require_once(ROOT . '/views/film/create.php');
        return true;
    }

    public function actionImport(): bool
    {
        $filmsList = $this->film->getFilmsListWithoutLimit();

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

                $executeQuery = $this->film->batchInsert($parsedFile);

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
        $filmsList = $this->film->getFilmsListWithoutLimit();
        $filmData = $this->film->getFilmById($id);
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
                $this->film->updateFilmById($id, $_POST);
                echo '<script>setTimeout(function () {
                    window.location.href = "/";  }, 2000);</script>';
            }
        }

        require_once(ROOT . '/views/film/update.php');
        return true;
    }

    public function actionDelete($id): bool
    {
        $filmData = $this->film->getFilmById($id);

        if (isset($_POST['submit'])) {
            $result = $this->film->deleteFilmById($id);
            header("Location: /");
        }
        require_once(ROOT . '/views/film/delete.php');
        return true;
    }

    public function actionView($id): bool
    {
        $filmData = $this->film->getFilmById($id);

        require_once(ROOT . '/views/film/view.php');
        return true;
    }

    private function actionFormats(): array
    {
        return $this->formats;
    }
}