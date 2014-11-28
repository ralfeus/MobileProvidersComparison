<?php
namespace My\MobileProvidersBundle\TariffCalc;

use APY\DataGridBundle\Grid\Column\NumberColumn;
use APY\DataGridBundle\Grid\Column\TextColumn;
use APY\DataGridBundle\Grid\Source\Vector;

class CostModelManager {
    private $costs;
    private $minTariff;

    private function __construct($costs, $minTariff) {
        $this->costs = $costs;
        $this->minTariff = $minTariff;
    }

    /**
     * @param UsagePattern $usagePattern
     * @param $tariffs
     * @return CostModelManager
     */
    public static function calculateCosts($usagePattern, $tariffs) {
        $costs = array();
        /** @var CostModel $minTariff */
        $minTariff = null;
        foreach ($tariffs as $tariff) {
            $calc = TariffCalcFactory::createCalc($tariff);
            $costs[] = $calc->getCost($usagePattern);
            if (is_null($minTariff) || ($calc->getCost($usagePattern)->getTotalCost() < $minTariff->getTotalCost())) {
                $minTariff = $calc->getCost($usagePattern);
            }
        }
        return new self($costs, $minTariff);
    }

    /**
     * @return CostModel[]
     */
    public function getCosts() {
        return $this->costs;
    }

    /**
     * @return CostModel
     */
    public function getMinTariff() {
        return $this->minTariff;
    }

    /**
     * @return Vector
     */
    public function getCostsVector() {
        $columns = [
            new TextColumn(['id' => 'tariff', 'field' => 'tariff', 'title' => 'Tariff', 'source' => true, 'primary' => true, 'filterable' => false, 'sortable' => false]),
            new TextColumn(['id' => 'provider', 'field' => 'provider', 'title' => 'Provider', 'source' => true, 'primary' => true, 'filterable' => false, 'sortable' => false]),
            new TextColumn(['id' => 'hardwareProvider', 'field' => 'hardwareProvider', 'title' => 'Hardware provider', 'source' => true, 'filterable' => false, 'sortable' => false]),
            new NumberColumn(['style' => 'currency', 'currencyCode' => 'CZK', 'id' => 'monthlyPayment', 'field' => 'monthlyPayment', 'title' => 'Monthly payment', 'source' => true, 'filterable' => false, 'sortable' => false]),
            new NumberColumn(['style' => 'decimal', 'id' => 'freeMinutes', 'field' => 'freeMinutes', 'title' => 'Free minutes', 'source' => true, 'filterable' => false, 'sortable' => false]),
            new NumberColumn(['style' => 'currency', 'currencyCode' => 'CZK', 'id' => 'internalCallsPrice', 'field' => 'internalCallsPrice', 'title' => 'Internal calls price', 'source' => true, 'filterable' => false, 'sortable' => false]),
            new NumberColumn(['style' => 'currency', 'currencyCode' => 'CZK', 'id' => 'externalCallsPrice', 'field' => 'externalCallsPrice', 'title' => 'External calls price', 'source' => true, 'filterable' => false, 'sortable' => false]),
            new NumberColumn(['style' => 'currency', 'currencyCode' => 'CZK', 'id' => 'totalCost', 'field' => 'totalCost', 'title' => 'Total cost', 'source' => true, 'filterable' => false, 'sortable' => false]),
        ];
        $data = array_map(
            function(CostModel $costModel) {
                return [
                    'tariff' => $costModel->getTariff(),
                    'provider' => $costModel->getProvider(),
                    'hardwareProvider' => $costModel->getHardwareProvider(),
                    'monthlyPayment' => $costModel->getMonthlyPayment(),
                    'freeMinutes' => $costModel->getFreeMinutes(),
                    'internalCallsPrice' => $costModel->getInternalCallsPrice(),
                    'externalCallsPrice' => $costModel->getExternalCallsPrice(),
                    'totalCost' => $costModel->getTotalCost()
                ];
            }, $this->getCosts()
        );
        $source = new Vector($data, $columns);
        $source->setId(['tariff', 'provider']);
        return $source;
    }
}