<?php
require_once('components/Parser.php');

class SiteController
{
    public function actionIndex()
    {
        if (isset($_POST['submit'])) {
            $parsedFile = Parser::parseFile($_FILES['text']['tmp_name']);
        }
        require_once('views/site/index.php');
        return true;
    }
}