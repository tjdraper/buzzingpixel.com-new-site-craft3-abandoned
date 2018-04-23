<?php

namespace dev\controllers;

use Craft;
use dev\Module;
use yii\web\Response;
use GuzzleHttp\Exception\GuzzleException;
use cebe\markdown\GithubMarkdown as Markdown;

/**
 * Class DocsController
 */
abstract class DocsController extends BaseController
{
    /**
     * Parses a docs page
     * @param string $directory
     * @param string $switcherTitle
     * @param array $switcher
     * @param string $backLink
     * @param string $childIndex
     * @return Response
     * @throws \Exception
     */
    protected function parsePage(
        string $directory,
        string $switcherTitle,
        array $switcher = [],
        string $backLink = '/',
        string $childIndex = ''
    ): Response {
        $vars = $this->getPageVariablesCommon(
            $directory,
            $switcherTitle,
            $switcher,
            $backLink,
            $childIndex
        );

        if (! $vars['pageContentModel']) {
            throw new \HttpException(404);
        }

        return $this->renderTemplate('_core/PageDocs.twig', $vars);
    }

    /**
     * Parses a GitHub Changelog page
     * @param string $directory
     * @param string $switcherTitle
     * @param array $switcher
     * @param string $backLink
     * @param string $metaTitle
     * @param string $rawChangelogUrl
     * @return Response
     * @throws \Exception
     * @throws GuzzleException
     * @throws \RuntimeException
     */
    protected function parseGithubChangelog(
        string $directory,
        string $switcherTitle,
        array $switcher,
        string $backLink,
        string $metaTitle,
        string $rawChangelogUrl
    ): Response {
        $vars = $this->getPageVariablesCommon(
            $directory,
            $switcherTitle,
            $switcher,
            $backLink
        );

        $vars['metaTitle'] = "{$metaTitle} | " . $vars['metaTitle'];

        $resp = Craft::createGuzzleClient()->request('GET', $rawChangelogUrl);
        $changelogMarkdown = $resp->getBody()->getContents();

        $html = '<div class="ChangelogMarkdownWrapper">';
        $html .= (new Markdown())->parse($changelogMarkdown);
        $html .= '</div>';

        $vars['pageSections'][] = [
            'markdown' => $changelogMarkdown,
            'meta' => null,
            'html' => $html,
        ];

        return $this->renderTemplate('_core/PageDocs.twig', $vars);
    }

    /**
     * Parses a GitHub Changelog page
     * @param string $directory
     * @param string $switcherTitle
     * @param array $switcher
     * @param string $backLink
     * @param string $metaTitle
     * @param string $changelogPath
     * @return Response
     * @throws \Exception
     * @throws GuzzleException
     * @throws \RuntimeException
     */
    protected function parseLocalChangelog(
        string $directory,
        string $switcherTitle,
        array $switcher,
        string $backLink,
        string $metaTitle,
        string $changelogPath
    ): Response {
        $vars = $this->getPageVariablesCommon(
            $directory,
            $switcherTitle,
            $switcher,
            $backLink
        );

        $vars['metaTitle'] = "{$metaTitle} | " . $vars['metaTitle'];

        $changelogMarkdown = file_get_contents($changelogPath);

        $html = '<div class="ChangelogMarkdownWrapper">';
        $html .= (new Markdown())->parse($changelogMarkdown);
        $html .= '</div>';

        $vars['pageSections'][] = [
            'markdown' => $changelogMarkdown,
            'meta' => null,
            'html' => $html,
        ];

        return $this->renderTemplate('_core/PageDocs.twig', $vars);
    }

    /**
     * Gets the variables common to pages
     * @param string $directory
     * @param string $switcherTitle
     * @param array $switcher
     * @param string $backLink
     * @param string $childIndex
     * @return array
     * @throws \Exception
     */
    private function getPageVariablesCommon(
        string $directory,
        string $switcherTitle,
        array $switcher = [],
        string $backLink = '/',
        string $childIndex = ''
    ): array {
        $contentModel = Module::fileContentService()->getContentFromDir(
            $directory
        );

        $content = $contentModel->getContent();
        $contentMeta = $content['meta'];

        $nav = $contentMeta['Nav'] ?? [];

        $fullUrlPath = '/' . ltrim(Craft::$app->getRequest()->fullPath, '/');

        $pageContentModel = $contentModel->getChildAtIndex($childIndex);

        $pageContentMeta = [];

        if ($pageContentModel) {
            $pageContent = $pageContentModel->getContent();
            $pageContentMeta = $pageContent['meta'];
        }

        $metaTitle = $pageContentMeta['metaTitle'] ??
            $pageContentMeta['title'] ??
            null;
        $metaDescription = $pageContentMeta['metaDescription'] ??
            $pageContentMeta['description'] ??
            null;

        if (! empty($contentMeta['title'])) {
            $metaTitle .= $metaTitle ? ' | ' : '';
            $metaTitle .= $contentMeta['title'];
        }

        $pageTitle = $pageContentMeta['title'] ?? '';

        $pageSections = [];

        if ($pageContentModel) {
            $pageSections = $pageContentModel->getVars();
        }

        return compact(
            'switcherTitle',
            'switcher',
            'backLink',
            'nav',
            'fullUrlPath',
            'metaTitle',
            'metaDescription',
            'pageContentModel',
            'pageTitle',
            'pageSections'
        );
    }
}
