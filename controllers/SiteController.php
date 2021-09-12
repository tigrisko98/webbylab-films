<?php
require_once('components/Parser.php');
require_once('models/Film.php');

class SiteController
{
    public function actionIndex()
    {
        $films = new Film();
       $filmsList = $films->getFilmsList();
        if (isset($_POST['submit'])) {
            $parsedFile = Parser::parseFile($_FILES['text']['tmp_name']);
            $executeQuery = $films->batchInsert($parsedFile);
            header("Location:/");
        }

        if (isset($_POST['submit_filters'])) {
            $filmsList = $films->filterByFields($_POST);
        }
        require_once('views/site/index.php');
        return true;
    }
}