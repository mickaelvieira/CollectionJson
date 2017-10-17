<?php
declare(strict_types = 1);

/*
 * This file is part of CollectionJson, a php implementation
 * of the Collection+JSON Media Type
 *
 * (c) Mickaël Vieira <contact@mickael-vieira.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CollectionJson\Validator;

use CollectionJson\Entity\Data;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Class Dataset
 * @package CollectionJson\Validator
 */
final class Dataset
{
    /**
     * Validator constructor.
     */
    public function __construct()
    {
        if (!class_exists(Validation::class)) {
            throw new \LogicException(
                'You need to install the Symfony Validator package to use this extension. ' .
                'You can install it with composer: `composer require symfony/validator`'
            );
        }
    }

    /**
     * Examples:
     *
     * $constraints = [
     *     'id' => [
     *         new Constraints\NotBlank(),
     *     ],
     *     'url' => [
     *         new Constraints\NotBlank(),
     *         new Constraints\Url(),
     *     ],
     *     'email' => [
     *         new Constraints\NotBlank(),
     *         new Constraints\Email(),
     *     ],
     * ];
     *
     * $template = (new Template())
     *     ->withData(new Data('id', '123'))
     *     ->withData(new Data('url', 'http://example.co'))
     *     ->withData(new Data('email', 'test@example.co'));
     *
     * $errors = (new Validator())
     *     ->validate($template->getDataSet(), $constraints);
     *
     * @param array $dataSet
     * @param array $constraints
     *
     * @return array
     */
    public function validate(array $dataSet, array $constraints): array
    {
        $errors    = [];
        $data      = self::flatten($dataSet);
        $validator = Validation::createValidator();

        foreach ($constraints as $name => $constraint) {
            $value = $data[$name] ?? null;
            $violations = $validator->validate($value, $constraint);

            foreach ($violations as $violation) {
                /** @var ConstraintViolationInterface $violation */
                $errors[$name] = [
                    'message'  => $violation->getMessage(),
                    'value'    => $violation->getInvalidValue(),
                ];
            }
        }

        return $errors;
    }

    /**
     * @param Data[] $dataSet
     *
     * @return array
     */
    public static function flatten(array $dataSet): array
    {
        return array_reduce($dataSet, function ($carry, Data $item) {
            $carry[$item->getName()] = $item->getValue();
            return $carry;
        }, []);
    }
}
