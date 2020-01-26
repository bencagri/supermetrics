<?php

namespace SuperMetrics\Domain;

interface CalculatorInterface
{

    /**
     * @param array $payload
     * @return array|Post[]
     */
    public function calculate(array $payload);

    /**
     * Name of calculator
     * @return string
     */
    public function name() : string;
}
