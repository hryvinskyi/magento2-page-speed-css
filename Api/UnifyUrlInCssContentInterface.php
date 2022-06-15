<?php
/*
 * Copyright (c) 2022. All rights reserved.
 * @author: Volodymyr Hryvinskyi <mailto:volodymyr@hryvinskyi.com>
 */

declare(strict_types=1);

namespace Hryvinskyi\PageSpeedCss\Api;

interface UnifyUrlInCssContentInterface
{
    public function execute(string $file, string $content): string;
}