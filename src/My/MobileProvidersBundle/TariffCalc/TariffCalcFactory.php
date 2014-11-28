<?php
namespace My\MobileProvidersBundle\TariffCalc;

use My\MobileProvidersBundle\Document\Tariff;
use Symfony\Component\Debug\Exception\ClassNotFoundException;

class TariffCalcFactory {
    private static $instances = array();

    /**
     * @param string $className
     * @throws ClassNotFoundException
     * @return BaseCalc
     */
    private static function getInstance($className) {
        if (!array_key_exists($className, TariffCalcFactory::$instances)) {
            if ($className === "BaseCalc") {
                TariffCalcFactory::$instances[$className] = new BaseCalc();
            } else {
                throw new ClassNotFoundException("The class '$className' is not found", new \ErrorException());
            }
        }
        return TariffCalcFactory::$instances[$className];
    }

    /**
     * @param Tariff $tariff
     * @return BaseCalc
     */
    public static function createCalc($tariff) {
        $newObject = clone TariffCalcFactory::getInstance("BaseCalc");
        $newObject->init($tariff);
        return $newObject;
    }
} 