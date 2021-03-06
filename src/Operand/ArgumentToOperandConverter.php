<?php

namespace Happyr\DoctrineSpecification\Operand;

use Happyr\DoctrineSpecification\Exception\NotConvertibleException;

/**
 * This service is intended for backward compatibility and may be removed in the future.
 */
class ArgumentToOperandConverter
{
    /**
     * Convert the argument into the field operand if it is not an operand.
     *
     * @param Operand|string $argument
     *
     * @return Operand
     */
    public static function toField($argument)
    {
        if ($argument instanceof Operand) {
            return $argument;
        }

        return new Field($argument);
    }

    /**
     * Convert the argument into the value operand if it is not an operand.
     *
     * @param Operand|string $argument
     *
     * @return Operand
     */
    public static function toValue($argument)
    {
        if ($argument instanceof Operand) {
            return $argument;
        }

        return new Value($argument);
    }

    /**
     * Are all arguments is a operands?
     *
     * @param array $arguments
     *
     * @return bool
     */
    public static function isAllOperands(array $arguments)
    {
        foreach ($arguments as $argument) {
            if (!($argument instanceof Operand)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Convert all possible arguments to operands.
     *
     * @param Operand[]|string[] $arguments
     *
     * @throws NotConvertibleException
     *
     * @return Operand[]
     */
    public static function convert(array $arguments)
    {
        if (!$arguments) {
            return [];
        }

        // always try convert the first argument to the field operand
        $field = self::toField(array_shift($arguments));

        if (!$arguments) {
            return [$field];
        }

        // always try convert the last argument to the value operand
        $value = self::toValue(array_pop($arguments));

        if (!$arguments) {
            return [$field, $value];
        }

        if (!self::isAllOperands($arguments)) {
            throw new NotConvertibleException('You passed arguments not all of which are operands.');
        }

        array_unshift($arguments, $field);
        array_push($arguments, $value);

        return $arguments;
    }
}
