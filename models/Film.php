<?php
require_once ('components/Db.php');
class Film
{
    private $db;

    public function __construct()
    {
        $this->db = Db::getConnection();
    }

    public function getFilmssList()
    {
        $result = $this->db->query('SELECT * FROM `films`');
        $result->setFetchMode(PDO::FETCH_ASSOC);

        return $result->fetchAll();
    }
}