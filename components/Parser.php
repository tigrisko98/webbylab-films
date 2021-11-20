<?php

class Parser
{
    public static function parseTxtOrDocFile(array $importFile)
    {
        if (Parser::getFileExtension($importFile) == 'txt') {
            $fileContent = file_get_contents($importFile['file']['tmp_name']);
        }
        if (Parser::getFileExtension($importFile) == 'docx') {
            $content = '';
            $zip = zip_open($importFile['file']['tmp_name']);

            if (is_numeric($zip)) {
                return false;
            }
                while ($zip_entry = zip_read($zip)) {

                    if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

                    if (zip_entry_name($zip_entry) != "word/document.xml") continue;

                    $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

                    zip_entry_close($zip_entry);
                }
                zip_close($zip);
                $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
                $content = str_replace('</w:r></w:p>', "\r\n", $content);
                $fileContent = strip_tags($content);

        }
        if(isset($fileContent)) {
            $pos = strpos($fileContent, "Title");
            $fileContent = substr($fileContent, $pos);

            $preparedText = array_map('trim', preg_split('/ *(Title|Release Year|Format|Stars): /', $fileContent));

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