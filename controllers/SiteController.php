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
        require_once('views/site/index.php');
        return true;
    }
}