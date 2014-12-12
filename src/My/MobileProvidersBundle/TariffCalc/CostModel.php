<?php
namespace My\MobileProvidersBundle\TariffCalc;

use My\MobileProvidersBundle\Document\Tariff;

/**
 * Class CostModel
 * @package My\MobileProvidersBundle\TariffCalc
 */
class CostModel {
    /** @var Tariff */
    private $tariff;
    private $cost;

    /**
     * @param Tariff $tariff
     * @param float $cost
     */
    public function __construct($tariff, $cost) {
        $this->tariff = $tariff;
        $this->cost = $cost;
    }

    /**
     * @return string
     */
    public function getProvider() {
        return $this->tariff->getProvider()->getName();
    }

    /**
     * @return string
     */
    public function getHardwareProvider() {
        return $this->tariff->getProvider()->getHardwareProvider()->getName();
    }

    /**
     * @return string
     */
    public function getTariff() {
        return $this->tariff->getName();
    }

    /**
     * @return float
     */
    public function getTotalCost() {
        return $this->cost;
    }

    /**
     * @param float $value
     * @return self
     */
    public function setTotalCost($value) {
        $this->cost = $value;
        return $this;
    }

    /**
     * @return int
     */
    public function getFreeMinutes() {
        return $this->tariff->getFreeMinutes();
    }

    /**
     * @return float
     */
    public function getMonthlyPayment() {
        return $this->tariff->getMonthlyPayment();
    }

    /**
     * @return int
     */
    public function getInternalCallsPrice() {
        return $this->tariff->getInternalCallsPrice();
    }

    /**
     * @return int
     */
    public function getExternalCallsPrice() {
        return $this->tariff->getExternalCallsPrice();
    }
}