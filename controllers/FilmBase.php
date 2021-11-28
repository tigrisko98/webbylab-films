<?php

class FilmBase
{
    protected $formats = ['DVD', 'VHS', 'Blu-Ray'];

    protected $film;

    public function __construct()
    {
        $this->film = new Film();
    }
}
