<?php

class SiteController
{
    public function actionIndex()
    {
        $films = new Film();
        $filmsList = $films->getFilmsList();

        if (isset($_POST['submit_filters_and_sort'])) {
            $filmsList = $films->filterAndSortByFields($_POST);
        }
        require_once('views/site/index.php');
        return true;
    }
}