<?php

class SiteController
{
    public function actionIndex($page = 1): bool
    {
        $films = new Film();
        $filmsList = $films->getFilmsList($page);
        $total = $films->getTotalFilms();

        if (isset($_POST['submit_filters_and_sort']) || !empty($_SESSION)) {
            foreach ($_POST as $key => $value) {
                $_SESSION[$key] = htmlspecialchars($value);
            }
            $filmsList = $films->filterAndSortByFields($_SESSION, $page);
            $total = $filmsList['count'];
        }
        $pagination = new Pagination($total, $page, $films::SHOW_BY_DEFAULT, 'page-', $filmsList['filmsList']);

        require_once('views/site/index.php');
        return true;
    }

    public function actionFiltersReset()
    {
        session_unset();
        header("Location: /");
        return true;
    }
}