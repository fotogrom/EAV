<?php
namespace App\Gromov\EAVBundle\Entity;

use DateTime;


class FieldNames implements FieldNamesInterface
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $entity;

    /**
     * @var string
     */
    protected $type;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var string
     */
    protected $defaultValue;
    /**
     * @var datetime
     */
    protected $createdAt;

    /**
     * @var integer
     */
    protected $enabled;

    /**
     * FieldNames constructor.
     */
    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->enabled = '1';
    }

     /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return int
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $entity
     */
    public function setEntity(string $entity): void
    {
        $this->entity = $entity;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param string $defaultValue
     */
    public function setDefaultValue(string $defaultValue): void
    {
        $this->defaultValue = $defaultValue;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param int $enabled
     */
    public function setEnabled(int $enabled)
    {
        $this->enabled = $enabled;
    }
}