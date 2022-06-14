<?php
/**
 * Copyright (c) 2022. MageCloud.  All rights reserved.
 * @author: Volodymyr Hryvinskyi <mailto:volodymyr@hryvinskyi.com>
 */

declare(strict_types=1);

namespace Hryvinskyi\PageSpeedCss\Model\Validator;

use Hryvinskyi\PageSpeedApi\Api\Finder\Result\TagInterface;
use Hryvinskyi\PageSpeedCss\Model\ValidatorInterface;

class CriticalCss implements ValidatorInterface
{
    /**
     * @inheritDoc
     */
    public function validate(TagInterface $style): bool
    {
        if (isset($style->getAttributes()['data-type']) && $style->getAttributes()['data-type'] === 'criticalCss') {
            return false;
        }

        return true;
    }
}
