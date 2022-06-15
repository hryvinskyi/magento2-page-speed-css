<?php
/**
 * Copyright (c) 2022. MageCloud.  All rights reserved.
 * @author: Volodymyr Hryvinskyi <mailto:volodymyr@hryvinskyi.com>
 */

declare(strict_types=1);

namespace Hryvinskyi\PageSpeedCss\Model\Validator;

use Hryvinskyi\PageSpeedApi\Api\Finder\Result\TagInterface;
use Hryvinskyi\PageSpeedCss\Api\ConfigInterface;
use Hryvinskyi\PageSpeedCss\Model\ValidatorInterface;

class Deferred implements ValidatorInterface
{
    public const DEFERRED = 'deferred';
    public const DEFER = 'defer';
    private ConfigInterface $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * @inheritDoc
     */
    public function validate(TagInterface $style): bool
    {
        if ($this->config->isOnlyDeferred()) {
            $isDeferred = isset($style->getAttributes()[self::DEFERRED]) === false || $style->getAttributes()[self::DEFERRED] === 'false';
            $isDefer = isset($style->getAttributes()[self::DEFER]) === false;
            return ($isDefer && $isDeferred) === false;
        }

        return true;
    }
}
