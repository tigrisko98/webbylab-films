<?php
require_once('models/Film.php');

class FilmController
{
    public function actionCreate()
    {
        $film = new Film();
        //$filmsList = $film->getFilmsList();
        if (isset($_POST['submit'])) {
            $film->createFilm($_POST);
            header("Location: /");
        }

        require_once(ROOT . '/views/film/create.php');
        return true;
    }
}