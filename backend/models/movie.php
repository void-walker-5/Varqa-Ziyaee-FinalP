<?php
class movie
{
    // DB Stuff
    private $conn;
    private $table = 'mymovies';

    // Movie Properties
    public $searchQuery;
    public $id;
    public $name;
    public $des;
    public $year;
    public $poster;

    // Constructor
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get Movies
    public function read()
    {
        // create query
        $query = 'SELECT * from ' . $this->table;
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get Movie by Id
    public function readById()
    {
        // create query
        $query = 'SELECT * from ' . $this->table . ' where id=?';
        $stmt = $this->conn->prepare($query);

        // Bind Id
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->des = $row['des'];
        $this->year = $row['year'];
        $this->poster = $row['poster'];

        return $stmt;
    }

    // Create Movie
    public function create()
    {
        // create query
        $query = 'insert into ' . $this->table . ' (name,des,year,poster) values(:name,:des,:year,:poster);';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data (for security)
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->des = htmlspecialchars(strip_tags($this->des));
        $this->year = htmlspecialchars(strip_tags($this->year));
        $this->poster = htmlspecialchars(strip_tags($this->poster));

        // Bind the data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':des', $this->des);
        $stmt->bindParam(':year', $this->year);
        $stmt->bindParam(':poster', $this->poster);

        // Execute query
        if ($stmt->execute()) {
            return true;
        } else {
            echo "error";
            return false;
        }
    }

    // Search Movies
    public function search()
    {
        // create query
        $query = 'select * from ' . $this->table . ' where name=:name or year=:year';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind the data
        if (isset($this->searchQuery)) {
            $stmt->bindParam(':name', $this->searchQuery);
            $stmt->bindParam(':year', $this->searchQuery);
        } else {
            $query = 'select * from ' . $this->table;
        }

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Delete Movies
    public function delete()
    {
        // create query
        $query = 'delete from ' . $this->table . ' where id=:id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind the data
        $stmt->bindParam(':id', $this->id);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Edit Movie
    public function edit()
    {
        // create query
        $query = 'update ' . $this->table . ' set name=:name, des=:des, year=:year, poster=:poster where id=:id;';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data (for security)
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->des = htmlspecialchars(strip_tags($this->des));
        $this->year = htmlspecialchars(strip_tags($this->year));
        $this->poster = htmlspecialchars(strip_tags($this->poster));

        // Bind the data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':des', $this->des);
        $stmt->bindParam(':year', $this->year);
        $stmt->bindParam(':poster', $this->poster);

        // Execute query
        if ($stmt->execute()) {
            return true;
        } else {
            echo "error";
            return false;
        }
    }
}