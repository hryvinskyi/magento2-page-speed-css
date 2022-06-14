<?php
/**
 * Copyright (c) 2022. MageCloud.  All rights reserved.
 * @author: Volodymyr Hryvinskyi <mailto:volodymyr@hryvinskyi.com>
 */

declare(strict_types=1);

namespace Hryvinskyi\PageSpeedCss\Model\Validator;

use Hryvinskyi\PageSpeedApi\Api\Finder\Result\TagInterface;
use Hryvinskyi\PageSpeedCss\Model\ValidatorInterface;

class Attribute implements ValidatorInterface
{
    public const IGNORE_ATTRIBUTE = 'data-ignore-extreme-lazy-load';

    /**
     * @inheritDoc
     */
    public function validate(TagInterface $style): bool
    {
        $ignoredAttributes = [self::IGNORE_ATTRIBUTE];

        return count(array_intersect($ignoredAttributes, array_keys($style->getAttributes()))) === 0;
    }
}
