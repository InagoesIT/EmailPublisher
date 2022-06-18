<?php

namespace app\models;

use app\core\App;
use app\core\DbModel;
use DateInterval;
use DateTime;

class Publication extends DbModel
{
    public ?int $id;
    public string $body;
    public bool $isPublic;
    public string $password;
    public string $link;
    public int $idUser;
    public $createdAt;
    public $expireAt;

    public function __construct()
    {
        $this->isPublic = true;
        $this->password = '';

        $now = new DateTime();
        $this->createdAt = $now->format('Y-m-d H:i:s');

        $never = (clone $now)->add(new DateInterval("P1000Y"));
        $this->expireAt = $never->format('Y-m-d H:i:s');
    }

//    public function __construct1(string $body, string $subject, bool $isPublic, string $password, int $idUser)
//    {
//        $this->body = $body;
//        $this->subject = $subject;
//        $this->isPublic = $isPublic;
//        $this->password = $password;
//        $this->idUser = $idUser;
//    }

    static public function tableName(): string
    {
        return 'publications';
    }

    static public function attributes(): array
    {
        return ['idUser', 'isPublic', 'password', 'body', 'link', 'createdAt', 'expireAt'];
    }

    static public function primaryKey(): string
    {
        return 'id';
    }

    public function rules(): array
    {
        // TODO: Implement rules() method. TREBUIE DE FACUT
        return [
            'idUser' => []
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

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getExpireAt()
    {
        return $this->expireAt;
    }

    /**
     * @param mixed $expireAt
     */
    public function setExpireAt($expireAt): void
    {
        $this->expireAt = $expireAt;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }





}