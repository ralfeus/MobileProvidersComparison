<?php
namespace My\MobileProvidersBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;

/**
 * @MongoDB\Document
 * Class HardwareProvider
 * @package My\MobileProvidersBundle\Document
 */
class HardwareProvider {
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\string
     */
    protected $name;

    /**
     * @return Id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return string
     */
    function __toString() {
        return $this->getName();
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

}
