<?php
include_once "Email.php";
include_once "MySQLDatabase.php";

class DBStorage
{

    private MySQLDatabase $mysqlDatabase;

    /**
     * DBStorage constructor.
     * @param MySQLDatabase $mysqlDatabase
     */
    public function __construct(MySQLDatabase $mysqlDatabase)
    {
        $this->mysqlDatabase = $mysqlDatabase;
        $this->mysqlDatabase->runSql("CREATE TABLE IF NOT EXISTS VAII.Emails(id int AUTO_INCREMENT PRIMARY KEY, user_name varchar(30) NOT NULL, email varchar(50) NOT NULL, text varchar(100) NOT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)");
    }

    /**
     * @return Email[]
     */
    public function getAll(): array
    {
        $result = [];
        $data = $this->mysqlDatabase->getConnection()->query("SELECT * FROM VAII.Emails");
        if ($data->num_rows > 0) {
            while ($row = $data->fetch_assoc()) {
                $id = $row["id"];
                $name = $row["user_name"];
                $email = $row["email"];
                $text = $row["text"];
                $createdAt = $row["created_at"];
                $result[] = new Email($id, $name, $email, $text, $createdAt);
            }
        }
        return $result;
    }

    public function getById($id): Email
    {
        $result = null;
        $data = $this->mysqlDatabase->getConnection()->query("SELECT * FROM VAII.Emails WHERE id='$id'");
        if ($data->num_rows == 1) {
            $row = $data->fetch_assoc();

            $id = $row["id"];
            $name = $row["user_name"];
            $email = $row["email"];
            $text = $row["text"];
            $createdAt = $row["created_at"];
            $result = new Email($id, $name, $email, $text, $createdAt);

        }
        return $result;
    }

    public function saveEmail(Email $email): bool
    {
        $name = $email->getName();
        $mail = $email->getEmail();
        $text = $email->getText();
        return $this->mysqlDatabase->runSql("INSERT INTO VAII.Emails(user_name,email,text) VALUES('$name','$mail','$text')");
    }

    public function deleteEmail($id): bool
    {
        return $this->mysqlDatabase->runSql("DELETE FROM VAII.Emails WHERE id='$id'");
    }

    public function updateEmail($id, $newName, $newEmail, $newText): bool
    {
        return $this->mysqlDatabase->runSql("UPDATE VAII.Emails SET user_name='$newName', email='$newEmail', text='$newText' WHERE id='$id'");
    }

}

?>