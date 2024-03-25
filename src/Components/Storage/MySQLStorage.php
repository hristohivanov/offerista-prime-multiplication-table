<?php

namespace App\Components\Storage;

use PDO;

class MySQLStorage implements StorageInterface
{
    private PDO $pdo;

    const MULTIPLICATION_RESULTS_TABLE = 'multiplication_results';
    const MULTIPLICATION_TABLES_TABLE = 'generated_tables';

    /**
     * @throws StorageException
     */
    public function __construct($storageConfiguration, $mockObject = null)
    {
        if ($mockObject === null) {
            try {
                $this->pdo = new PDO(
                    $storageConfiguration['dsn'],
                    $storageConfiguration['username'],
                    $storageConfiguration['password'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]);
            } catch (\PDOException $exception) {
                throw new StorageException($exception);
            };
        } else {
            $this->pdo = $mockObject;
        }
    }

    public function saveData($table, $multiplicationName): bool
    {
        try {
            $this->pdo->beginTransaction();

            // Insert data into generated_tables table
            $stmt = $this->pdo->prepare("INSERT INTO generated_tables (table_name, date_generated) VALUES (?, NOW())");
            $stmt->execute([$multiplicationName]);
            $generatedTableId = $this->pdo->lastInsertId();

            // Prepare the insert statement
            $insertSql = "INSERT INTO " . self::MULTIPLICATION_RESULTS_TABLE . " (generated_table_id, row_index, column_index, value) 
                          VALUES (:generated_table_id, :row_index, :column_index, :value)";
            $statement = $this->pdo->prepare($insertSql);

            // Insert values into the table
            foreach ($table as $rowIndex => $row) {
                foreach ($row as $columnIndex => $value) {
                    $statement->bindParam(':generated_table_id', $generatedTableId, PDO::PARAM_INT);
                    $statement->bindParam(':row_index', $rowIndex, PDO::PARAM_INT);
                    $statement->bindParam(':column_index', $columnIndex, PDO::PARAM_INT);
                    $statement->bindParam(':value', $value, PDO::PARAM_INT);
                    $statement->execute();
                }
            }

            $this->pdo->commit();

            return true;
        } catch (\PDOException $exception) {
            $this->pdo->rollBack();
            throw new StorageException($exception);
        }
    }

    /**
     * Using setup method to create the tables
     */
    public function setUp(): bool
    {
        return $this->setUpGeneratedTablesTable() && $this->setUpMultiplicationResultsTable();
    }

    /**
     * Creating mysql table with the basic information about the generated table
     */
    private function setUpGeneratedTablesTable(): bool
    {
        // Create the table if it doesn't exist
        $createTableSql = sprintf("CREATE TABLE %s (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `date_generated` DATETIME NOT NULL,
                `table_name` VARCHAR(255) NOT NULL
            )", self::MULTIPLICATION_TABLES_TABLE);

        $result = $this->pdo->exec($createTableSql);

        return is_int($result) ? $result >= 0 : $result;
    }

    /**
     * Creating mysql table with the generated results from the generated table
     */
    private function setUpMultiplicationResultsTable(): bool
    {
        // Create the table if it doesn't exist
        $createTableSql = sprintf("CREATE TABLE IF NOT EXISTS %s (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `generated_table_id` INT NOT NULL,
            `row_index` INT NOT NULL,
            `column_index` INT NOT NULL,
            `value` BIGINT,
            FOREIGN KEY (`generated_table_id`) REFERENCES %s(id)
        )", self::MULTIPLICATION_RESULTS_TABLE, self::MULTIPLICATION_TABLES_TABLE);

        $result = $this->pdo->exec($createTableSql);

        return is_int($result) ? $result >= 0 : $result;
    }

    private function truncateTable(): void
    {
        $truncateSql = "TRUNCATE TABLE " . self::MULTIPLICATION_RESULTS_TABLE;
        $this->pdo->exec($truncateSql);
    }
}