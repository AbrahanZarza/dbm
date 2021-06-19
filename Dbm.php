<?php

class Dbm
{
    public static function getInstance()
    {
        return new DBInstance();
    }
}

final class DBInstance
{
    private $conn;

    public function __construct()
    {
        try {
            $db = $_ENV['DB'];
            $host = $_ENV['DB_HOST'];
            $port = $_ENV['DB_PORT'];
            $user = $_ENV['DB_USER'];
            $password = $_ENV['DB_PASSWORD'];
            $databaseName = $_ENV['DB_NAME'];

            $this->conn = new \PDO("$db:host=$host;port=$port;dbname=$databaseName;charset=utf8", $user, $password, [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ]);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public function executeS(string $query, array $bindParams = null, bool $destroyInstance = true)
    {
        return $this->getResults($query, $bindParams, false, $destroyInstance);
    }

    public function getRow(string $query, array $bindParams = null, bool $destroyInstance = true)
    {
        return $this->getResults($query, $bindParams, true, $destroyInstance);
    }

    public function execute(string $query, array $bindParams = null, bool $destroyInstance = true)
    {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($bindParams);
        $lastInsertId = $this->conn->lastInsertId();

        $stmt->closeCursor();
        if ($destroyInstance) $this->destroy();

        return $lastInsertId;
    }

    public function destroy()
    {
        $this->conn = null;
    }

    private function getResults(string $query, array $bindParams = null, bool $singleRow = false, bool $destroyInstance = true)
    {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($bindParams);
        $results = $singleRow ? $stmt->fetch(\PDO::FETCH_ASSOC) : $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $stmt->closeCursor();
        if ($destroyInstance) $this->destroy();

        return $results;
    }
}