<?php
namespace App\Gromov\EAVBundle\Entity;

use DateTime;
class FieldValues implements FieldValuesInterface
{
    /**
     * @var integer
     */
    protected $fieldName;

    /**
     * @var integer
     * number of id data of bounded entity
     */
    protected $entityData;

    /**
     * @var text
     */
    protected $val;

    /**
     * @var datetime
     */
    protected $createdAt;

    /**
     * @var integer
     */
    protected $enabled;

    /**
     * FieldValues constructor.
     */
    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->enabled = '1';
    }


    /**
     * @return int
     */
    public function getFieldName(): int
    {
        return $this->fieldName;
    }

    /**
     * @return longtext
     */
    public function getVal()
    {
        return $this->val;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
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
     * @return int
     */
    public function getEntityData(): int
    {
        return $this->entityData;
    }


    /**
     * @param int $fieldName
     */
    public function setFieldName(int $fieldName): void
    {
        $this->fieldName = $fieldName;
    }

    /**
     * @param longtext $val
     */
    public function setVal( $val): void
    {
        $this->val = $val;
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

    /**
     * @param int $entityDataId
     */
    public function setEntityData(int $entityData): void
    {
        $this->entityData = $entityData;
    }



}