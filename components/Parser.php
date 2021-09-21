<?php

class Parser
{
    public static function parseFile($importFile)
    {
        $textFileContent = file_get_contents($importFile);
        $pos = strpos($textFileContent, "Title");
        $textFileContent = substr($textFileContent, $pos);

        $preparedText = preg_split('/ *(Title|Release Year|Format|Stars): /', $textFileContent);

        if (!isset($preparedText[1])) {
            return false;
        }

        if (!strlen(trim($preparedText[0]))) {
            unset($preparedText[0]);
        }

        $dataToInsert = array_chunk($preparedText, 4);
        return $dataToInsert;
    }
}