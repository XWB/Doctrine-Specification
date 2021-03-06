<?php

namespace Happyr\DoctrineSpecification\Operand;

class BitLeftShift extends Bitwise
{
    /**
     * @param Operand|string $field
     * @param Operand|string $value
     */
    public function __construct($field, $value)
    {
        parent::__construct(self::B_LS, $field, $value);
    }
}
