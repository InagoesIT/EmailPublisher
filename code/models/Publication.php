<?php

namespace app\models;

use app\core\App;
use app\core\DbModel;

class Publication extends DbModel
{
    public int $id;
    public string $body;
    public string $subject;
    public bool $isPublic;
    public string $password;
    public int $idUser;

    /**
     * @param String $body
     * @param String $subject
     * @param bool $isPublic
     * @param String $password
     */
    public function __construct()
    {
    }

    public function __construct1(string $body, string $subject, bool $isPublic, string $password, int $idUser)
    {
        $this->body = $body;
        $this->subject = $subject;
        $this->isPublic = $isPublic;
        $this->password = $password;
        $this->idUser = $idUser;
    }

    static public function tableName(): string
    {
        return 'publications';
    }

    static public function attributes(): array
    {
        return ['idUser', 'body', 'subject', 'isPublic', 'password'];
    }

    static public function primaryKey(): string
    {
        return 'id';
    }

    public function rules(): array
    {
        // TODO: Implement rules() method. TREBUIE DE FACUT
        return [
            'isUser' => []
        ];
    }

    /**
     * @return int
     */
    public function getIdUser(): int
    {
        return $this->idUser;
    }

    /**
     * @param int $idUser
     */
    public function setIdUser(int $idUser): void
    {
        $this->idUser = $idUser;
    }


    /**
     * @return String
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param String $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * @return String
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param String $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return bool
     */
    public function isPublic(): bool
    {
        return $this->isPublic;
    }

    /**
     * @param bool $isPublic
     */
    public function setIsPublic(bool $isPublic): void
    {
        $this->isPublic = $isPublic;
    }

    /**
     * @return String
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param String $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }


}