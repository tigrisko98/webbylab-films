<?php

class FilmController
{
    public function actionCreate()
    {
        $film = new Film();
        if (isset($_POST['submit'])) {
            $film->createFilm($_POST);
            header("Location: /");
        }

        require_once(ROOT . '/views/film/create.php');
        return true;
    }

    public function actionUpdate($id)
    {
        $film = new Film();
        $filmData = $film->getFilmById($id);

        if (isset($_POST['submit'])) {
            $film->updateFilmById($id, $_POST);
            header("Location: /");
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