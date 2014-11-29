<?php
namespace My\MobileProvidersBundle\TariffCalc;

use My\MobileProvidersBundle\Document\Tariff;

class BaseCalc {
    /** @var Tariff */
    protected $tariff;

    /**
     * @param Tariff $tariff
     */
    public function init($tariff) {
        $this->tariff = $tariff;
    }

    /**
     * @param UsagePattern $usagePattern
     * @return CostModel
     */
    public function getCost($usagePattern) {
        $extraExpenses = 0;
        if ($usagePattern->getTotalCalls() > $this->tariff->getFreeMinutes()) {
            $extraExpenses =
                ($usagePattern->getTotalCalls() - $this->tariff->getFreeMinutes()) * // calls not covered by free minutes
                (
                    $usagePattern->getInternalCalls(true) * $this->tariff->getInternalCallsPrice() + // internal calls estimated expense
                    $usagePattern->getExternalCalls(true) * $this->tariff->getExternalCallsPrice() // external calls estimated expense
                );
        }
        return new CostModel($this->tariff, $this->tariff->getMonthlyPayment() + $extraExpenses);
    }
}