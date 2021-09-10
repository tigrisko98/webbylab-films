<?php

return [
    'film/create' => 'film/create',
    'film/update/([0-9]+)' => 'film/update/$1',
    'film/delete/([0-9]+)' => 'film/delete/$1',
    '' => 'site/index'
];