<?php
/**
 * Copyright (c) 2022. MageCloud.  All rights reserved.
 * @author: Volodymyr Hryvinskyi <mailto:volodymyr@hryvinskyi.com>
 */

declare(strict_types=1);

namespace Hryvinskyi\PageSpeedCss\Model;

use Hryvinskyi\PageSpeedCss\Api\ConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config implements ConfigInterface
{
    public const XML_PATH_ENABLE_MOVE_TO_BOTTOM = 'hryvinskyi_pagespeed/css/enable_move_to_bottom';
    public const XML_PATH_ENABLE_MERGE_INLINE_CSS = 'hryvinskyi_pagespeed/css/enable_merge_inline_css';

    private ScopeConfigInterface $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @inheritdoc
     */
    public function isOnlyDeferred($scopeCode = null, string $scopeType = ScopeInterface::SCOPE_STORE): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function isEnableMergeInlineCss($scopeCode = null, string $scopeType = ScopeInterface::SCOPE_STORE): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLE_MERGE_INLINE_CSS, $scopeCode, $scopeType);
    }

    /**
     * @inheritDoc
     */
    public function isEnableMoveToBottom($scopeCode = null, string $scopeType = ScopeInterface::SCOPE_STORE): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLE_MOVE_TO_BOTTOM, $scopeCode, $scopeType);
    }
}
