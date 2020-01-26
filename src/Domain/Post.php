<?php

namespace SuperMetrics\Domain;

class Post
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $fromName;

    /**
     * @var string
     */
    private $fromId;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $type;

    /**
     * @var \DateTime
     */
    private $createdAt;

    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->fromArray($data);
        }
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getFromName()
    {
        return $this->fromName;
    }

    /**
     * @param string $fromName
     * @return $this
     */
    public function setFromName($fromName)
    {
        $this->fromName = $fromName;

        return $this;
    }

    /**
     * @return string
     */
    public function getFromId()
    {
        return $this->fromId;
    }

    /**
     * @param string $fromId
     * @return $this
     */
    public function setFromId($fromId)
    {
        $this->fromId = $fromId;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt() : \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = new \DateTime($createdAt);

        return $this;
    }


    /**
     * @param array $array
     * @return Post
     */
    public function fromArray(array $array = []): Post
    {
        return $this
            ->setId($array['id'])
            ->setFromId($array['from_id'])
            ->setFromName($array['from_name'])
            ->setMessage($array['message'])
            ->setType($array['type'])
            ->setCreatedAt($array['created_time']);
    }

    public function __invoke($params)
    {
        return $this->fromArray($params);
    }
}
