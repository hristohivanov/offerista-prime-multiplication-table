<?php

namespace App\Components\Storage;

interface StorageInterface
{
    /**
     * @throws StorageException
     */
    public function __construct($storageConfiguration, $mock = null);

    /**
     * Used to save all result.
     *
     * @throws StorageException
     */
    public function saveData($table);

    /**
     * Used to execute all needed instructions before using the main program.
     *
     * @throws StorageException
     */
    public function setUp(): bool;
}