<?php
namespace My\MobileProvidersBundle\TariffCalc;

class Tariff547a22388d8c0d1069f33a19Calc extends BaseCalc {
    /**
     * @param UsagePattern $usagePattern
     * @return CostModel
     */
    public function getCost($usagePattern) {

        return new CostModel(
            $this->tariff,
            $this->getCallsCost($usagePattern->getInternalCalls() + $usagePattern->getExternalCalls())
        );
    }

    /**
     * @param int $internalCallsMinutes
     * @return float
     */
    private function getCallsCost($internalCallsMinutes) {
        $costs =   [
            ['min' => 50, 'price' => 1.9],
            ['min' => 50, 'price' => 1.7],
            ['min' => 100, 'price' => 1.45],
            ['min' => 100, 'price' => 1.15],
            ['min' => 100, 'price' => 0.9],
            ['min' => 100, 'price' => 0.7]
        ];
        return $this->calculateExpenses($internalCallsMinutes, $costs);
    }

    /**
     * @param $callsMinutes
     * @param $costs
     * @return mixed
     */
    private function calculateExpenses($callsMinutes, $costs) {
        $expenses = 0;
        foreach ($costs as $cost) {
            if ($callsMinutes < 0) {
                break;
            }
            $expenses += ($callsMinutes > $cost['min'] ? $cost['min'] : $callsMinutes) * $cost['price'];
            $callsMinutes -= $cost['min'];
        }
        return $expenses;
    }
}