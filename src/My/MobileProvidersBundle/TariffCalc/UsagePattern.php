<?php
namespace My\MobileProvidersBundle\TariffCalc;

class UsagePattern {
    private $internalCalls;
    private $externalCalls;

    /**
     * @param int $externalCalls
     * @param int $internalCalls
     */
    function __construct($externalCalls = null, $internalCalls = null) {
        $this->externalCalls = $externalCalls;
        $this->internalCalls = $internalCalls;
    }

    /**
     * @param bool $ratio
     * @return float
     */
    public function getExternalCalls($ratio = false) {
        if ($ratio) {
            return $this->externalCalls / $this->getTotalCalls();
        } else {
            return $this->externalCalls;
        }
    }

    /*
     * @param int $value
     * @return self
     */
    public function setExternalCalls($value) {
        $this->externalCalls = $value;
        return $this;
    }

    /**
     * @param bool $ratio
     * @return float
     */
    public function getInternalCalls($ratio = false) {
        if ($ratio) {
            return $this->internalCalls / $this->getTotalCalls();
        } else {
            return $this->internalCalls;
        }
    }

    /**
     * @param int $value
     * @return self
     */
    public function setInternalCalls($value) {
        $this->internalCalls = $value;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalCalls() {
        return $this->getInternalCalls() + $this->getExternalCalls();
    }
}