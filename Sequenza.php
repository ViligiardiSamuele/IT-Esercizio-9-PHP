<?php
class Sequenza
{
    protected $colori;

    public function __construct($colori)
    {
        $this->colori = $colori;
    }

    public function getColoreN($i)
    {
        if (isset($this->colori[$i]))
            return $this->colori[$i];
    }
}
