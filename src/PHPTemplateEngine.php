<?php

namespace Piccolo\Templating\Engine\PHP;

use Piccolo\Templating\TemplateEngine;

/**
 * This class is a template engine provider that utilizes the plain PHP template engine to render templates.
 *
 * Example:
 *
 * fooController.php
 * ```
 * <?php $templateLayout = 'baseLayout'; ?>
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
     * {@inheritdoc}
     */
    public function getExtension() : string
    {
        return 'php';
    }

    /**
     * {@inheritdoc}
     */
    public function renderFile(string $templateRoot, string $fileName, array $data) : string
    {
        extract($data, EXTR_SKIP);

        ob_start();
        require_once \realpath($fileName);
        $templateContent = ob_get_clean();

        if (isset($templateLayout)) {
            $layoutFileName = \realpath($templateRoot) . DIRECTORY_SEPARATOR . $templateLayout
                . '.' . $this->getExtension();

            if (file_exists($layoutFileName)) {
                require_once $layoutFileName;
                $templateContent = ob_get_clean();
            }
        }
        return $templateContent;
    }
}
