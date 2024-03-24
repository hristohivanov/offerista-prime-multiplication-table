<?php

namespace App\Components\Storage;

class MySQLStorage implements StorageInterface
{
    private \PDO $pdo;

    const MULTIPLICATION_RESULTS_TABLE = 'multiplication_results';

    /**
     * @throws StorageException
     */
    public function __construct($storageConfiguration, $mockObject = null)
    {
        if ($mockObject === null) {
            try {
                $this->pdo = new \PDO(
                    $storageConfiguration['dsn'],
                    $storageConfiguration['username'],
                    $storageConfiguration['password'], [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
                ]);
            } catch (\PDOException $exception) {
                throw new StorageException($exception);
            };
        } else {
            $this->pdo = $mockObject;
        }
    }

    public function saveData($table): bool
    {
        try {
            $this->truncateTable();

            $this->pdo->beginTransaction();

            // Prepare the insert statement
            $insertSql = "INSERT INTO " . self::MULTIPLICATION_RESULTS_TABLE . " (row_index, column_index, value) 
                          VALUES (:row_index, :column_index, :value)";
            $statement = $this->pdo->prepare($insertSql);

            // Insert values into the table
            foreach ($table as $rowIndex => $row) {
                foreach ($row as $columnIndex => $value) {
                    $statement->bindParam(':row_index', $rowIndex, \PDO::PARAM_INT);
                    $statement->bindParam(':column_index', $columnIndex, \PDO::PARAM_INT);
                    $statement->bindParam(':value', $value, \PDO::PARAM_INT);
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
     * Using setup method to create the table
     */
    public function setUp(): bool
    {
        // Create the table if it doesn't exist
        $createTableSql = "CREATE TABLE IF NOT EXISTS " . self::MULTIPLICATION_RESULTS_TABLE . " (
            id INT AUTO_INCREMENT PRIMARY KEY,
            row_index INT,
            column_index INT,
            value BIGINT
        )";

        $result = $this->pdo->exec($createTableSql);

        return is_int($result) ? $result >= 0 : $result;
    }

    private function truncateTable(): void
    {
        $truncateSql = "TRUNCATE TABLE " . self::MULTIPLICATION_RESULTS_TABLE;
        $this->pdo->exec($truncateSql);
    }
}