<?php

class Parser
{
    public static function parseTxtOrDocFile(array $importFile)
    {
        if (Parser::getFileExtension($importFile) == 'txt' || Parser::getFileExtension($importFile) == 'doc'
        || Parser::getFileExtension($importFile) == 'docx') {
            $fileContent = file_get_contents($importFile['file']['tmp_name']);
            $pos = strpos($fileContent, "Title");
            $fileContent = substr($fileContent, $pos);

            $preparedText = preg_split('/ *(Title|Release Year|Format|Stars): /', $fileContent);

            if (!isset($preparedText[1])) {
                return false;
            }

            if (!strlen(trim($preparedText[0]))) {
                unset($preparedText[0]);
            }

            $dataToInsert = array_chunk($preparedText, 4);
            $dataToInsert = self::removeInvalidFormats($dataToInsert);

            return $dataToInsert;
        }
    }

    public static function parseCsvFile(array $importFile)
    {
        if (($fileResource = fopen("{$importFile['file']['tmp_name']}", 'r')) !== false) {
            while (($fileData = fgetcsv($fileResource, 1000, ',')) !== false) {
                $dataToInsert[] = $fileData;
            }
            fclose($fileResource);
        }

        if (!isset($dataToInsert[1])) {
            return false;
        }
        $dataToInsert = self::removeInvalidFormats($dataToInsert);
        return $dataToInsert;
    }

    public static function getFileExtension(array $importFile): string
    {
        $fileExtension = pathinfo($importFile['file']['name'], PATHINFO_EXTENSION);

        return $fileExtension;
    }

    private static function removeInvalidFormats(array $dataToInsert): array
    {
        foreach ($dataToInsert as $key => $value) {
            if (!in_array(trim($value[2]), ['DVD', 'VHS', 'Blu-Ray'])) {
                unset($dataToInsert[$key]);
            }
        }

        return $dataToInsert;
    }
}