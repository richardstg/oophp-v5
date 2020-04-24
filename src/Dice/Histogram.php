<?php

namespace Rist\Dice;

/**
 * Generating histogram data.
 */
class Histogram
{
    /**
     * @var array $serie  The numbers stored in sequence.
     * @var int   $min    The lowest possible number.
     * @var int   $max    The highest possible number.
     */
    private $serie = [];
    private $min;
    private $max;



    /**
     * Inject the object to use as base for the histogram data.
     *
     * @param HistogramInterface $object The object holding the serie.
     *
     * @return void.
     */
    public function injectData(HistogramInterface $object)
    {
        $this->serie = $object->getHistogramSerie();
        $this->min   = $object->getHistogramMin();
        $this->max   = $object->getHistogramMax();
    }



    /**
     * Get the serie.
     *
     * @return array with the serie.
     */
    public function getSerie()
    {
        return $this->serie;
    }



    /**
     * Return a string with a textual representation of the histogram.
     *
     * @return string representing the histogram.
     */
    public function getAsText()
    {
        foreach ($this->getSerie() as $key => $value) {
            if ($this->min && $this->max) {
                $this->printWithMinAndMax($key, $value);
            } else if ($this->min) {
                $this->printWithMin($key, $value);
            } else if ($this->max) {
                $this->printWithMax($key, $value);
            } else {
                print_r($key + 1 . ": " . str_repeat("*", $value) . "\n");
            }
        }
    }

    /**
     * Return a string with a textual representation of the histogram.
     *
     * @return string representing the histogram.
     */
    public function printWithMinAndMax($key, $value)
    {
        $value >= $this->min && $value <= $this->max ?
            print_r($key + 1 . ": " . str_repeat("*", $value) . "\n") :
            print_r($key + 1 . ": " . "" . "\n");
    }

    /**
     * Return a string with a textual representation of the histogram.
     *
     * @return string representing the histogram.
     */
    public function printWithMin($key, $value)
    {
        $value >= $this->min ?
            print_r($key + 1 . ": " . str_repeat("*", $value) . "\n") :
            print_r($key + 1 . ": " . "" . "\n");
    }

    /**
     * Return a string with a textual representation of the histogram.
     *
     * @return string representing the histogram.
     */
    public function printWithMax($key, $value)
    {
        $value <= $this->max ?
            print_r($key + 1 . ": " . str_repeat("*", $value) . "\n") :
            print_r($key + 1 . ": " . "" . "\n");
    }
}
