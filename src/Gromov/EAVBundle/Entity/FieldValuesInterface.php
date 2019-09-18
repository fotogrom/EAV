<?php
namespace App\Gromov\EAVBundle\Entity;

use DateTime;


interface FieldValuesInterface
{
    /**
     * @return integer
     */
   public function getFieldName();

    /**
     * @return longtext
     */
   public function getVal();

    /**
     * @return datetime
     */
   public function getCreatedAt();

    /**
     * @return integer
     */
    public function getEnabled();

    /**
     * @param string $fieldName
     * @return mixed
     */
   public function setFieldName(int $fieldName);

    /**
     * @param longtext $val
     * @return mixed
     */
   public function setVal($val);

    /**
     * @param DateTime $createdAt
     * @return mixed
     */
   public function setCreatedAt(Datetime $createdAt);

    /**
     * @param integer $enabled
     * @return mixed
     */
    public function setEnabled(int $enabled);
}