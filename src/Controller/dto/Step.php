<?php

namespace Wead\Controller\dto;

final class Step
{
    public $id;
    public $text;
    public $wait;
    public $required;
    public $namespace;
    public $next;

    public function __construct(\stdClass $row)
    {
        foreach (array_keys(get_object_vars($this)) as $k) {
            $this->$k = $row->$k;
        }
    }
}
