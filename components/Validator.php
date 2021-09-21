<?php
//require_once ('models/Film.php');
class Validator
{
    public static $errors = [];

    public static function validateFilm($options, $filmsList = [])
    {
        foreach ($filmsList as $film) {
            if (in_array($options['title'], $film)) {
                self::$errors[] = 'This film is already been added.';
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
            if (empty($options[$key])) {
                self::$errors[] = str_replace('_', ' ', ucfirst($key)) . ' is required.';
            }
        }
        return self::$errors;
    }

    public static function validateImportFile($importFile)
    {
        if (!in_array(pathinfo($importFile, PATHINFO_EXTENSION), ['txt', 'doc', 'docx', 'csv']) && !empty($_POST['file'])) {
            self::$errors[] = 'Invalid file extension.';
        }

        return self::$errors;
    }
}