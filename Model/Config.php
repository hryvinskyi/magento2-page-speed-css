<?php
/**
 * Copyright (c) 2022. MageCloud.  All rights reserved.
 * @author: Volodymyr Hryvinskyi <mailto:volodymyr@hryvinskyi.com>
 */

declare(strict_types=1);

namespace Hryvinskyi\PageSpeedCss\Model;

use Hryvinskyi\PageSpeedCss\Api\ConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config implements ConfigInterface
{
    /**
     * @inheritdoc
     */
    public function isOnlyDeferred($scopeCode = null, string $scopeType = ScopeInterface::SCOPE_STORE): bool
    {
        return false;
    }
}
