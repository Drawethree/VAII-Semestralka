<?php


class MySQLDatabase {

private string $host;
private string $user;
private string $password;
private mysqli $connection;

    public function __construct()
    {
        $this->host = "localhost";
        $this->user = "root";
        $this->password = "dtb456";
        $this->connect();
    }


    public function connect() : bool
    {
        $this->connection = mysqli_connect($this->host, $this->user, $this->password);

        if (!$this->connection) {
            return false;
        }
        return true;
    }

    public function close() {
        if ($this->connection != null) {
            $this->connection->close();
        }
    }

    public function runSql($sql) : bool {
        return (mysqli_query($this->connection, $sql));
    }

    public function getConnection() : mysqli
    {
        return $this->connection;
    }
}
?>