<?php
/**
 * Copyright (c) 2022. MageCloud.  All rights reserved.
 * @author: Volodymyr Hryvinskyi <mailto:volodymyr@hryvinskyi.com>
 */

declare(strict_types=1);

namespace Hryvinskyi\PageSpeedCss\Model;

use Hryvinskyi\PageSpeedApi\Api\Finder\Result\TagInterface;
use Hryvinskyi\PageSpeedCss\Api\CanCssMoveToBottomInterface;
use Hryvinskyi\PageSpeedJsExtremeLazyLoad\Model\ValidatorInterface;

class CanCssMoveToBottom implements CanCssMoveToBottomInterface
{
    /**
     * @var ValidatorInterface[]
     */
    private array $validators;

    /**
     * @param ValidatorInterface[] $validators
     */
    public function __construct(array $validators = [])
    {
        $this->validators = $validators;
    }

    /**
     * @inheritDoc
     */
    public function execute(TagInterface $tag): bool
    {
        foreach ($this->validators as $validator) {
            if ($validator->validate($tag) === false) {
                return false;
            }
        }

        return true;
    }
}
