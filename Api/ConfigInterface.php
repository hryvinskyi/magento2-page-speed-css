<?php
/**
 * Copyright (c) 2022. MageCloud.  All rights reserved.
 * @author: Volodymyr Hryvinskyi <mailto:volodymyr@hryvinskyi.com>
 */

declare(strict_types=1);

namespace Hryvinskyi\PageSpeedCss\Api;

use Magento\Store\Model\ScopeInterface;

interface ConfigInterface
{
    /**
     * Returns is enabled move to bottom css.
     *
     * @param $scopeCode
     * @param string $scopeType
     * @return bool
     */
    public function isEnableMoveToBottom($scopeCode = null, string $scopeType = ScopeInterface::SCOPE_STORE): bool;

    /**
     * Returns is enabled merge inline css.
     *
     * @param $scopeCode
     * @param string $scopeType
     * @return bool
     */
    public function isEnableMergeInlineCss($scopeCode = null, string $scopeType = ScopeInterface::SCOPE_STORE): bool;
}
