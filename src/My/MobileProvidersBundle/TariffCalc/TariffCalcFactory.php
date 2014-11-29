<?php
namespace My\MobileProvidersBundle\TariffCalc;

use My\MobileProvidersBundle\Document\Tariff;
use Symfony\Component\Debug\Exception\ClassNotFoundException;
use Symfony\Component\Debug\Exception\FatalErrorException;

class TariffCalcFactory {
    private static $instances = array();

    /**
     * @param string $className
     * @throws ClassNotFoundException
     * @return BaseCalc
     */
    private static function getInstance($className) {
        if (!array_key_exists($className, TariffCalcFactory::$instances)) {
            $classFQN = "My\\MobileProvidersBundle\\TariffCalc\\" . $className;
            if (class_exists($classFQN)) {
                TariffCalcFactory::$instances[$className] = new $classFQN();
            } else {
                throw new ClassNotFoundException("Class $classFQN was not found", new \ErrorException());
            }
        }
        return TariffCalcFactory::$instances[$className];
    }

    /**
     * @param Tariff $tariff
     * @return BaseCalc
     */
    public static function createCalc($tariff) {
        try {
            $newObject = clone TariffCalcFactory::getInstance("Tariff" . $tariff->getId() . "Calc");
        } catch (\Exception $exc) {
            $newObject = clone TariffCalcFactory::getInstance("BaseCalc");
        }
        $newObject->init($tariff);
        return $newObject;
    }
} 