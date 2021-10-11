<?php

class SiteController
{
    public function actionIndex(): bool
    {
        $films = new Film();
        $filmsList = $films->getFilmsList();

        if (isset($_POST['submit_filters_and_sort'])) {
            $filmsList = $films->filterAndSortByFields($_POST);
        }
        require_once('views/site/index.php');
        return true;
    }

    public function actionFiltersReset()
    {
        unset($_POST);
        header("Location: /");
        return true;
    }
}