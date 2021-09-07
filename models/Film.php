<?php
require_once('components/Db.php');

class Film
{
    private $db;

    public function __construct()
    {
        $this->db = Db::getConnection();
    }

    public function getFilmsList()
    {
        $result = $this->db->query('SELECT * FROM `films`');
        $result->setFetchMode(PDO::FETCH_ASSOC);

        return $result->fetchAll();
    }

    public function batchInsert(array $parsedData)
    {
        $stmt = $this->db->prepare('INSERT INTO `films` '
            . '(title, release_year, format, stars_list)'
            . 'VALUES '
            . '(?, ?, ?, ?)');
        try {
            $this->db->beginTransaction();
            foreach ($parsedData as $row) {
                $stmt->execute($row);
            }
            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollback();
            throw $e;
        }
        return true;
    }
}