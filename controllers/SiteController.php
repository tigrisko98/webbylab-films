<?php

class SiteController extends FilmBaseController
{
    public function actionIndex($page = 1): bool
    {
        $filmsList = $this->film->getFilmsList($page);
        $total = $this->film->getTotalFilms();

        if (isset($_POST['submit_filters_and_sort']) || !empty($_SESSION)) {
            foreach ($_POST as $key => $value) {
                $_SESSION[$key] = htmlspecialchars($value);
            }
            $filmsList = $this->film->filterAndSortByFields($_SESSION, $page);
            $total = $filmsList['count'];
        }
        $pagination = new Pagination($total, $page, $this->film::SHOW_BY_DEFAULT, 'page-', $filmsList['filmsList']);

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