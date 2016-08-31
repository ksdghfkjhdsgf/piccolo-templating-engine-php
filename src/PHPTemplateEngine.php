<?php

namespace Piccolo\Templating\Engine\PHP;

use Piccolo\Templating\TemplateEngine;
use Piccolo\Templating\TemplateFilter;
use Piccolo\Templating\TemplateFunction;
use Piccolo\Templating\TemplateNotFoundException;

/**
 * This class is a template engine provider that utilizes the plain PHP template engine to render templates.
 *
 * Example:
 *
 * fooController.php
 * ```
 * <?php $this->setLayout('baseLayout'); ?>
 * <h1>Piccolo Application</h1>
 * ```
 *
 * baseLayout.php
 * ```
 * <!DOCTYPE html>
 * <html lang="en">
 * <head>
 * <title>Piccolo Application</title>
 * </head>
 * <body>
 * <?php echo $templateContent ?>
 * </body>
 * </html>
 * ```
 *
 * @package Templating
 */
class PHPTemplateEngine implements TemplateEngine
{
    /**
     * @var string
     */
    private $templateLayout;

    /**
     * {@inheritdoc}
     */
    public function getExtension() : string
    {
        return 'php';
    }

    /**
     * {@inheritdoc}
     */
    public function renderFile(string $templateRoot,
                               string $fileName,
                               array $data,
                               array $templateRoots = []) : string
    {
        \extract($data, EXTR_SKIP);

        \ob_start();
        require_once \realpath($fileName);
        $templateContent = \ob_get_clean();

        if ($this->templateLayout) {
            $layoutFileName = \realpath($templateRoot) . DIRECTORY_SEPARATOR . $this->templateLayout .
                '.' . $this->getExtension();

            if (\is_file($layoutFileName) && \is_readable($layoutFileName)) {
                require_once $layoutFileName;
                $templateContent = \ob_get_clean();
            } else {
                throw new TemplateNotFoundException('Template layout ' . $this->templateLayout .
                    ' not found in directory ' . $templateRoot);
            }
        }

        return $templateContent;
    }

    /**
     * @param string $templateLayout
     */
    private function setLayout(string $templateLayout)
    {
        $this->templateLayout = $templateLayout;
    }

    /**
     * @param TemplateFilter $filter
     */
    public function registerFilter(TemplateFilter $filter)
    {

    }

    /**
     * @param TemplateFunction $function
     */
    public function registerFunction(TemplateFunction $function)
    {

    }
}
