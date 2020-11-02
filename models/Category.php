<?php

class Category
{
	// DB
	public $id;

	// Properties
	public $name;
	private $conn;
	private $table = 'categories';

	// Constructor

	public function __construct($db)
	{
		$this->conn = $db;
	}

	// Get Posts
	public function read()
	{
		// Create query
		$query = 'SELECT
                    id,
					name
				FROM
					' . $this->table . ' 
				ORDER BY
					id DESC';

		$stmt = $this->conn->prepare($query);

		$stmt->execute();

		return $stmt;
	}

	public function read_single()
	{
		$query = 'SELECT
                    id,
					name
				FROM
					' . $this->table . ' p
				WHERE 
					id = ?
				LIMIT 0,1';

		// Prepare statement
		$stmt = $this->conn->prepare($query);

		// Bind ID
		$stmt->bindParam(1, $this->id);

		//Execute query
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		// Set properties
		$this->name = $row['name'];
	}

	// Create post
	public function create() {
		// Create query
		$query = 'INSERT INTO ' . 
			$this->table . '
			SET
				name = :name';

		// Prepare statement
		$stmt = $this->conn->prepare($query);

		// Clean data
		$this->name = htmlspecialchars(strip_tags($this->name));

		// Bind data
		$stmt->bindParam(':name', $this->name);

		// Execute query
		if ($stmt->execute()) {
			return true;
		}

		// Print error
		printf("Error: %s.\n", $stmt->error);

		return false;
	}

	public function update() {
		// Update query
		$query = 'UPDATE ' . 
			$this->table . '
			SET
				name = :name
			WHERE
				id = :id';
		
		// Prepare statement
		$stmt = $this->conn->prepare($query);

		// Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->id = htmlspecialchars(strip_tags($this->id));

		// Bind data
        $stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':id', $this->id);
        

		if ($stmt->execute()) {
			return true;
		}

		// Print error
		printf("Error: %s.\n", $stmt->error);

		return false;
	}

	public function delete() {
		// Create quert
		$query = 'DELETE FROM ' . 
			$this->table . 
			' WHERE id = :id';

		// Prepare statement
		$stmt = $this->conn->prepare($query);

		// Clear data
		$this->id = htmlspecialchars(strip_tags($this->id));

		// Bind data
		$stmt->bindParam(':id', $this->id);

		if ($stmt->execute()) {
			return true;
		}

		// Print error
		printf("Error: %s.\n", $stmt->error);

		return false;
	}
}
