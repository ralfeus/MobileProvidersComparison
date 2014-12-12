<?php
namespace My\MobileProvidersBundle\TariffCalc;

class Tariff547a22398d8c0d1069f33a9eCalc extends BaseCalc {
    private $minExpense = 40;
    /**
     * @param UsagePattern $usagePattern
     * @return CostModel
     */
    public function getCost($usagePattern) {
        $costModel = parent::getCost($usagePattern);
        if ($costModel->getTotalCost() < $this->minExpense) {
            $costModel->setTotalCost($this->minExpense);
        }
        return $costModel;
    }
}