<?php

return [
    'film/create' => 'film/create',
    'film/update/([0-9]+)' => 'film/update/$1',
    'film/delete/([0-9]+)' => 'film/delete/$1',
    'film/([0-9]+)' => 'film/view/$1',
    'film/import' => 'film/import',
    'film/formats' => 'film/formats',
    'filters/reset' => 'site/filtersReset',
    'page-([0-9]+)' => 'site/index/$1',
    '' => 'site/index'
];