<?php


class MySQLDatabase {

private $host;
private $user;
private $password;
private $connection;

    /**
     * MySQLDatabase constructor.
     * @param $host
     * @param $user
     * @param $password
     */
    public function __construct($host, $user, $password)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;

        $this->connect();
    }


    private function connect()
    {
        $this->connection = mysqli_connect($this->servername, $this->username, $this->password);

        if (!$this->connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        echo "Connected successfully";
    }

    public function close() {
        if ($this->connection != null) {
            $this->connection->close();
        }
    }

    public function runSql($sql) : bool {
        return ($this->connection->query($sql));
    }
}
?>