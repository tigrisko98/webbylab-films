<?php

class FilmController
{
    public function actionCreate()
    {
        $film = new Film();
        $filmsList = $film->getFilmsList();
        if (isset($_POST['submit'])) {
            $errors = Validator::validateFilm($_POST, $filmsList);
            if (empty($errors)) {
                $film->createFilm($_POST);
                header("Location: /");
            }
        }

        require_once(ROOT . '/views/film/create.php');
        return true;
    }

    public function actionImport()
    {
        $films = new Film();

        if (isset($_POST['submit'])) {
            $importFile = $_FILES;
            $errors = Validator::validateImportFile($importFile);

            if (empty($errors)) {
                $parsedFile = Parser::parseFile($importFile['file']['tmp_name']);
                $executeQuery = $films->batchInsert($parsedFile);

                if ($executeQuery !== true) {
                    $errors[] = 'Invalid file.';
                } else {
                    header("Location:/");
                }

            }
        }

        require_once(ROOT . '/views/film/import.php');
        return true;
    }

    public function actionUpdate($id)
    {
        $film = new Film();
        $filmsList = $film->getFilmsList();
        $filmData = $film->getFilmById($id);

        if (isset($_POST['submit'])) {
            $errors = Validator::validateFilm($_POST);
            if (empty($errors)) {
                $film->updateFilmById($id, $_POST);
                header("Location: /");
            }
        }

        require_once(ROOT . '/views/film/update.php');
        return true;
    }

    public function actionDelete($id)
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

    public function actionView($id)
    {
        $film = new Film();
        $filmData = $film->getFilmById($id);

        require_once(ROOT . '/views/film/view.php');
        return true;
    }
}