<?php
namespace App\Gromov\EAVBundle\Entity;

use DateTime;

interface FieldNamesInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getEntity();

    /**
     * @return string
     */
    public function getType();

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @return string
     */
    public function getDefaultValue();

    /**
     * @return datetime
     */
    public function getCreatedAt();

    /**
     * @return integer
     */
    public function getEnabled();

    /**
     * @param string $name
     * @return mixed
     */
    public function setName(string $name);

    /**
     * @param string $entity
     * @return mixed
     */
    public function setEntity(string $entity);

    /**
     * @param string $type
     * @return mixed
     */
    public function setType(string $type);

    /**
     * @param string $description
     * @return mixed
     */
    public function setDescription(string $description);

    /**
     * @param string $defaultValue
     * @return mixed
     */
    public function setDefaultValue(string $defaultValue);

    /**
     * @param datetime $createdAt
     * @return mixed
     */
    public function setCreatedAt(DateTime $createdAt);

    /**
     * @param integer $enabled
     * @return mixed
     */
    public function setEnabled(int $enabled);
}