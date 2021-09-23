<?php

class Parser
{
    public static function parseTxtOrDocFile(string $importFile)
    {
        $fileContent = file_get_contents($importFile);
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
        return $dataToInsert;
    }

    public static function parseCsvFile(string $importFile)
    {
        if (($fileResource = fopen("{$importFile}", 'r')) !== false) {
            while (($fileData = fgetcsv($fileResource, 1000, ',')) !== false) {
                $dataToInsert[] = $fileData;
            }
            fclose($fileResource);
        }

        if (!isset($dataToInsert[1])) {
            return false;
        }

        return $dataToInsert;
    }

    public static function getFileExtension(array $importFile): string
    {
        $fileExtension = pathinfo($importFile['file']['name'], PATHINFO_EXTENSION);

        return $fileExtension;
    }
}