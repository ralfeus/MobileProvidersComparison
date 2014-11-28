<?php
namespace My\MobileProvidersBundle\Document;
use APY\DataGridBundle\Grid\Mapping as Grid;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;

/**
 * @MongoDB\Document
 * @Grid\Source(columns="name, hardwareProvider")
 * Class Provider
 * @package My\MobileProvidersBundle\Document
 */
class Provider {
    /**
     * @MongoDB\Id
     */
    protected $id;
    /**
     * @MongoDB\string
     * @Grid\Column(title="Name", filterable=true, primary=true)
     */
    protected $name;

    /**
     * @MongoDB\ReferenceOne(targetDocument="HardwareProvider")
     * @Grid\Column(title="Hardware Provider", filterable=false)
     */
    protected $hardwareProvider;

    /**
     * @return string
     */
    function __toString() {
        return $this->getName();
    }


    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set hardwareProvider
     *
     * @param string $hardwareProvider
     * @return self
     */
    public function setHardwareProvider($hardwareProvider)
    {
        $this->hardwareProvider = $hardwareProvider;
        return $this;
    }

    /**
     * Get hardwareProvider
     *
     * @return HardwareProvider $hardwareProvider
     */
    public function getHardwareProvider()
    {
        return $this->hardwareProvider;
    }
}
