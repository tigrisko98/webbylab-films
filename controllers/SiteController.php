<?php

class SiteController
{
    public function actionIndex($page = 1): bool
    {
        $films = new Film();
        $filmsList = $films->getFilmsList($page);
        $total = $films->getTotalFilms();

        $pagination = new Pagination($total, $page, $films::SHOW_BY_DEFAULT, 'page-');


        if (isset($_POST['submit_filters_and_sort'])) {
            $filmsList = $films->filterAndSortByFields($_POST, $page);
        }
        print_r($filmsList);
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