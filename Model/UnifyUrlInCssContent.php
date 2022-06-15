<?php
/*
 * Copyright (c) 2022. All rights reserved.
 * @author: Volodymyr Hryvinskyi <mailto:volodymyr@hryvinskyi.com>
 */

declare(strict_types=1);

namespace Hryvinskyi\PageSpeedCss\Model;

use Hryvinskyi\PageSpeedCss\Api\UnifyUrlInCssContentInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Url\CssResolver;
use Magento\Store\Model\StoreManagerInterface;

class UnifyUrlInCssContent implements UnifyUrlInCssContentInterface
{
    private Filesystem $filesystem;
    private StoreManagerInterface $storeManager;

    /**
     * @var array|string|string[]
     */
    private $callbackFileDir;

    public function __construct(Filesystem $filesystem, StoreManagerInterface $storeManager)
    {
        $this->filesystem = $filesystem;
        $this->storeManager = $storeManager;
    }

    /**
     * @param string $file
     * @param string $content
     * @return string
     */
    public function execute(string $file, string $content): string
    {
        $baseDir = $this->filesystem->getDirectoryRead(DirectoryList::ROOT)->getAbsolutePath();
        if (strpos($file, $baseDir) === 0) {
            $file = substr_replace($file, '', 0, strlen($baseDir));
            $file = ltrim($file, '/' . DIRECTORY_SEPARATOR);
        }

        $this->callbackFileDir = str_replace(DIRECTORY_SEPARATOR, '/', dirname($file));

        $cssImport = '/@import\\s+([\'"])(.*?)[\'"]/';
        $content = preg_replace_callback($cssImport, [$this, 'cssMergerImportCallback'], $content);

        $cssUrl = CssResolver::REGEX_CSS_RELATIVE_URLS;

        return preg_replace_callback($cssUrl, [$this, 'cssMergerUrlCallback'], $content);
    }

    /**
     * Callback function replaces relative links for @import matches in css file
     *
     * @param array $match
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function cssMergerImportCallback(array $match): string
    {
        $quote = $match[1];
        $uri = $this->prepareUrl($match[2]);

        return "@import {$quote}{$uri}{$quote}";
    }

    /**
     * Callback function replaces relative links for url() matches in css file
     *
     * @param array $match
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function cssMergerUrlCallback(array $match): string
    {
        $quote = ($match[1][0] === "'" || $match[1][0] === '"') ? $match[1][0] : '';
        $uri = ($quote === '') ? $match[1] : substr($match[1], 1, -1);
        $uri = $this->prepareUrl($uri);

        return "url({$quote}{$uri}{$quote})";
    }

    /**
     * Prepare url for css replacement
     *
     * @param string $uri
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function prepareUrl(string $uri): string
    {
        // check absolute or relative url
        if (!preg_match('/^https?:/i', $uri) && !preg_match('/^\//i', $uri)) {
            $fileDir = '';
            $pathParts = explode('/', $uri);
            $fileDirParts = explode('/', $this->callbackFileDir);
            $store = $this->storeManager->getStore();
            switch (true) {
                case count($fileDirParts) > 1 && 'media' === $fileDirParts[1]:
                    $baseUrl = $this->storeManager->getStore()->getBaseUrl(
                        UrlInterface::URL_TYPE_MEDIA,
                        $store->isCurrentlySecure()
                    );
                    $fileDirParts = array_slice($fileDirParts, 2);
                    break;
                case count($fileDirParts) > 1 && 'static' === $fileDirParts[1]:
                    $baseUrl = $this->storeManager->getStore()->getBaseUrl(
                        UrlInterface::URL_TYPE_STATIC,
                        $store->isCurrentlySecure()
                    );
                    $fileDirParts = array_slice($fileDirParts, 2);
                    break;
                default:
                    $baseUrl = $this->storeManager->getStore()->getBaseUrl(
                        UrlInterface::URL_TYPE_WEB,
                        $store->isCurrentlySecure()
                    );
            }

            foreach ($pathParts as $key => $part) {
                if ($part === '.' || $part === '..') {
                    unset($pathParts[$key]);
                }
                if ($part === '..' && count($fileDirParts)) {
                    $fileDirParts = array_slice($fileDirParts, 0, count($fileDirParts) - 1);
                }
            }

            if (count($fileDirParts)) {
                $fileDir = implode('/', $fileDirParts) . '/';
            }

            $uri = $baseUrl . $fileDir . implode('/', $pathParts);
        }

        return $uri;
    }
}
