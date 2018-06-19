<?php

namespace Core;

use App\Config;

/**
 * View
 *
 * PHP version 7.0
 */
class View
{

    /**
     * Render a view file
     *
     * @param string $view The view file
     * @param array $args Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = dirname(__DIR__) . "/App/Views/$view";  // relative to Core directory

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }
    }

    /**
     * Render a view template using Twig
     *
     * @param string $template The template file
     * @param array $args Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function renderTemplate($template, $args = [])
    {
        static $twig = null;

        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem(dirname(__DIR__) . '/App/Views');
            $twig = new \Twig_Environment($loader);
            $twig->addExtension(new \Twig_Extensions_Extension_I18n());

            $locale = Session::get('locale');
            $locale = ($locale) ? $locale : Config::DEFAULT_LOCALE;

            $domain = "messages";
            $lpath = realpath((dirname(__DIR__)) . DIRECTORY_SEPARATOR . "locale");

            putenv("LANGUAGE=" . $locale);
            setlocale(LC_ALL, $locale);
            bindtextdomain($domain, $lpath);
            textdomain($domain);
            $args['app']['session'] = $_SESSION;
        }

        echo $twig->render($template, $args);
    }
}
