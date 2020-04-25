<?php

namespace Wead\Controller\dto;

final class Route
{
    public $from;
    public $to;
    public $value;

    public function __construct($row)
    {
        foreach (array_keys(get_object_vars($this)) as $k => $v) {
            $this->$v = $row->$k;
        }
    }
}