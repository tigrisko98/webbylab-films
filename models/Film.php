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

    public function createFilm($options)
    {
        $sql = 'INSERT INTO `films` '
            . '(title, release_year, format, stars_list)'
            . 'VALUES '
            . '(:title, :release_year, :format, :stars_list)';

        $result = $this->db->prepare($sql);
        $result->bindParam(':title', $options['title'], PDO::PARAM_STR);
        $result->bindParam(':release_year', $options['release_year'], PDO::PARAM_INT);
        $result->bindParam(':format', $options['format'], PDO::PARAM_STR);
        $result->bindParam(':stars_list', $options['stars_list'], PDO::PARAM_STR);

        return $result->execute();
    }

    public function getFilmById($id)
    {
        if ($id = intval($id)) {
            $result = $this->db->query('SELECT * FROM `films` WHERE id=' . $id);
            $result->setFetchMode(PDO::FETCH_ASSOC);

            return $result->fetch();
        }
    }

    public function updateFilmById($id, $options)
    {

        $sql = 'UPDATE `films` SET 
                        title = :title, 
                        release_year = :release_year, 
                        format = :format, 
                        stars_list = :stars_list 
                        WHERE id = :id';

        $result = $this->db->prepare($sql);
        $result->bindParam(':title', $options['title'], PDO::PARAM_STR);
        $result->bindParam(':release_year', $options['release_year'], PDO::PARAM_INT);
        $result->bindParam(':format', $options['format'], PDO::PARAM_STR);
        $result->bindParam(':stars_list', $options['stars_list'], PDO::PARAM_STR);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        return $result->execute();

    }

    public function deleteFilmById($id)
    {
        $sql = 'DELETE FROM `films` WHERE id = :id';

        $result = $this->db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        return $result->execute();
    }
}