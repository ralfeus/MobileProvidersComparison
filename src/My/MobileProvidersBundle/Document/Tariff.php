<?php
namespace My\MobileProvidersBundle\Document;
use APY\DataGridBundle\Grid\Mapping as Grid;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 * @Grid\Source()
 *
 * Class Tariff
 * @package My\MobileProvidersBundle\Document
 */
class Tariff {
    /**
     * @MongoDB\Id
     * @Grid\Column(primary=true, visible=false)
     */
    protected $id;
    /**
     * @MongoDB\string
     * @Grid\Column(title="Name")
     */
    protected $name;
    /**
     * @MongoDB\ReferenceOne(targetDocument="Provider")
     * @Grid\Column(title="Provider")
     */
    protected $provider;
    /**
     * @MongoDB\float
     * @Grid\Column(title="Monthly payment")
     */
    protected $monthlyPayment;
    /**
     * @MongoDB\int
     * @Grid\Column(title="Free minutes")
     */
    protected $freeMinutes;
    /**
     * @MongoDB\float
     * @Grid\Column(title="Internal calls price")
     */
    protected $internalCallsPrice;
    /**
     * @MongoDB\float
     * @Grid\Column(title="External calls price")
     */
    protected $externalCallsPrice;

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
     * Set provider
     *
     * @param Provider $provider
     * @return self
     */
    public function setProvider(Provider $provider)
    {
        $this->provider = $provider;
        return $this;
    }

    /**
     * Get provider
     *
     * @return Provider $provider
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Set monthlyPayment
     *
     * @param float $monthlyPayment
     * @return self
     */
    public function setMonthlyPayment($monthlyPayment)
    {
        $this->monthlyPayment = $monthlyPayment;
        return $this;
    }

    /**
     * Get monthlyPayment
     *
     * @return float $monthlyPayment
     */
    public function getMonthlyPayment()
    {
        return $this->monthlyPayment;
    }

    /**
     * Set freeMinutes
     *
     * @param int $freeMinutes
     * @return self
     */
    public function setFreeMinutes($freeMinutes)
    {
        $this->freeMinutes = $freeMinutes;
        return $this;
    }

    /**
     * Get freeMinutes
     *
     * @return int $freeMinutes
     */
    public function getFreeMinutes()
    {
        return $this->freeMinutes;
    }

    /**
     * Set internalCallsPrice
     *
     * @param float $internalCallsPrice
     * @return self
     */
    public function setInternalCallsPrice($internalCallsPrice)
    {
        $this->internalCallsPrice = $internalCallsPrice;
        return $this;
    }

    /**
     * Get internalCallsPrice
     *
     * @return float $internalCallsPrice
     */
    public function getInternalCallsPrice()
    {
        return $this->internalCallsPrice;
    }

    /**
     * Set externalCallsPrice
     *
     * @param float $externalCallsPrice
     * @return self
     */
    public function setExternalCallsPrice($externalCallsPrice)
    {
        $this->externalCallsPrice = $externalCallsPrice;
        return $this;
    }

    /**
     * Get externalCallsPrice
     *
     * @return float $externalCallsPrice
     */
    public function getExternalCallsPrice()
    {
        return $this->externalCallsPrice;
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
}
