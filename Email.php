<?php


class Email
{

    private string $name;
    private string $email;
    private string $text;
    private int $id;
    private $createdAt;

    public function __construct($id, $name, $email, $text, $createdAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->text = $text;
        $this->createdAt = $createdAt;
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }


}