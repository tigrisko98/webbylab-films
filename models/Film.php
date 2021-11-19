<?php

class Film
{
    const SHOW_BY_DEFAULT = 10;
    private $db;
    protected $table = 'films';
    protected $fillable = ['id', 'title', 'release_year', 'format', 'stars_list'];

    public function __construct()
    {
        $this->db = Db::getConnection();
    }

    public function getFilmsList($page = 1): array
    {
        $limit = self::SHOW_BY_DEFAULT;
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

        $sql = ("SELECT * FROM $this->table LIMIT :limit OFFSET :offset");
        $result = $this->db->prepare($sql);

        $result->bindParam(':limit', $limit, PDO::PARAM_INT);
        $result->bindParam(':offset', $offset, PDO::PARAM_INT);

        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);

        return [$result->fetchAll()];
    }

    public function getFilmsListWithoutLimit(): array
    {
        $result = $this->db->query("SELECT * FROM $this->table");
        $result->setFetchMode(PDO::FETCH_ASSOC);

        return $result->fetchAll();
    }

    public function getFilmById($id)
    {
        $sql = ("SELECT * FROM $this->table WHERE id = ?");
        $result = $this->db->prepare($sql);

        $result->execute([$id]);
        $result->setFetchMode(PDO::FETCH_ASSOC);

        return $result->fetch();
    }

    public function getTotalFilms(): int
    {
        $sql = 'SELECT COUNT(id) AS count FROM `films`';
        $result = $this->db->prepare($sql);
        $result->execute();
        $row = $result->fetch();
        return $row['count'];
    }

    public function createFilm($options): bool
    {
        $sql = "INSERT INTO $this->table "
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

    public function updateFilmById($id, $options): bool
    {
        $sql = "UPDATE $this->table SET 
                        title = :title, 
                        release_year = :release_year, 
                        format = :format, 
                        stars_list = :stars_list 
                        WHERE id = :id";

        $result = $this->db->prepare($sql);
        $result->bindParam(':title', $options['title'], PDO::PARAM_STR);
        $result->bindParam(':release_year', $options['release_year'], PDO::PARAM_INT);
        $result->bindParam(':format', $options['format'], PDO::PARAM_STR);
        $result->bindParam(':stars_list', $options['stars_list'], PDO::PARAM_STR);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        return $result->execute();
    }

    public function deleteFilmById($id): bool
    {
        $sql = "DELETE FROM $this->table WHERE id = ?";

        $result = $this->db->prepare($sql);

        return $result->execute([$id]);
    }

    public function batchInsert(array $parsedData)
    {
        $result = $this->db->prepare("INSERT INTO $this->table "
            . '(title, release_year, format, stars_list)'
            . 'VALUES '
            . '(?, ?, ?, ?)');

        $this->db->beginTransaction();

        foreach ($parsedData as $row) {
            $executions[] = $result->execute($row);
        }

        if (in_array(true, $executions)) {
            $this->db->commit();
        } else {
            $this->db->rollback();
            return 'Invalid file.';
        }
        return true;
    }

    public function filterAndSortByFields(array $filtersAndSortOptions = null, $page = 1): array
    {
        $sql = "SELECT * FROM $this->table";
        $limit = self::SHOW_BY_DEFAULT;
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;
        $values = [];

        if (!empty($filtersAndSortOptions['title']) || !empty($filtersAndSortOptions['stars_list'])) {
            $sql = $sql . " WHERE ";
            foreach ($filtersAndSortOptions as $key => $value) {
                if (!empty($value) && in_array($key, $this->fillable)) {
                    $sql .= "$key LIKE ?";
                    $sql .= ' AND ';
                    $values[] = "%" . trim($value) . "%";
                }
            }
            $sql = substr($sql, 0, -5);
        }

        if (!empty($filtersAndSortOptions['sort_field'])) {
            $sql .= " ORDER BY $filtersAndSortOptions[sort_field]";
        }

        if (!empty($filtersAndSortOptions['direction'])) {
            $sql .= " $filtersAndSortOptions[direction]";
        }
        $sql .= " LIMIT $limit OFFSET $offset";

        $result = $this->db->prepare($sql);
        $result->execute(array_values($values));
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $sql2 = 'SELECT COUNT(id) AS count FROM `films`';
        $result2 = $this->db->prepare($sql2);
        $result2->execute();
        $row = $result2->fetch();

        return [$result->fetchAll(),  $row['count']];

    }
}