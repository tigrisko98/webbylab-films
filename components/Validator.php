<?php

class Validator
{
    public static $errors = [];

    public static function validateFilm(array $options, array $filmsList = []): array
    {
        foreach ($filmsList as $film) {
            if ($options['title'] == trim($film['title']) && $options['release_year'] == trim($film['release_year'])
                && $options['format'] == trim($film['format']) && trim($options['stars_list']) == trim($film['stars_list'])) {
                self::$errors[] = 'This film is already been added.';
                break;
            }
        }

        if ((!is_numeric($options['release_year']) && !empty($options['release_year'])) || $options['release_year'] < 0) {
            self::$errors[] = 'Release year must be a positive number.';
        }

        if ((is_numeric($options['release_year']) && $options['release_year'] < 1901 && !empty($options['release_year']))) {
            self::$errors[] = 'Release year is too low';
        }

        if ($options['release_year'] > 2021 && !empty($options['release_year'])) {
            self::$errors[] = 'Release year is too high';
        }

        if (!in_array($options['format'], ['DVD', 'VHS', 'Blu-Ray']) && !empty($options['format'])) {
            self::$errors[] = 'Format must be "DVD", "VHS" or "Blu-Ray"';
        }

        foreach ($options as $key => $value) {
            if (empty($options[$key]) || preg_match('/^\s+$/', $options[$key])) {
                self::$errors[] = str_replace('_', ' ', ucfirst($key)) . ' is required.';
            }
        }

        if (!preg_match('/^[a-zA-Z]+([ -]?[a-zA-Z])+(([,]|[, ])*[a-zA-Z]+([ -]?[a-zA-Z]))*( )*$/',
                $options['stars_list']) && !empty($options['stars_list']) && !preg_match('/^\s+$/', $options['stars_list'])) {
            self::$errors[] = 'Invalid name of the star (stars).';
        }

        $starsList = explode(', ', trim($options['stars_list']));
        $starsList = array_diff(array_map('trim', $starsList), ['']);
        $duplicates = array_unique(array_diff_assoc($starsList, array_unique($starsList)));
        if (!empty($duplicates)) {
            self::$errors[] = 'Duplicate found in Stars list field.';
        }
        return self::$errors;
    }

    public static function validateImportFile(array $importFile, array $filmsList): array
    {
        if (!in_array(pathinfo($importFile['file']['name'], PATHINFO_EXTENSION), ['txt', 'doc', 'docx', 'csv'])) {
            self::$errors[] = 'Invalid file extension.';
        }

        if (Parser::parseTxtOrDocFile($importFile) === false && Parser::parseCsvFile($importFile) === false) {
            self::$errors[] = 'No data to import.';
        }

        if (Parser::getFileExtension($importFile) == 'csv') {
            foreach (Parser::parseCsvFile($importFile) as $item) {
                foreach ($filmsList as $film) {
                    $commonValues = [];
                    $commonValues = array_intersect($item, $film);
                    if(count($commonValues) == 4){
                        self::$errors[] = "You have already been added «$film[title]».";
                    }
                }
            }
        } else {
            foreach (Parser::parseTxtOrDocFile($importFile) as $item) {
                foreach ($filmsList as $film) {
                    $commonValues = [];
                    $commonValues = array_intersect($item, $film);

                    if(count($commonValues) == 4){
                        self::$errors[] = "You have already been added «$film[title]».";
                    }
                }
            }
        }

        return self::$errors;
    }
}