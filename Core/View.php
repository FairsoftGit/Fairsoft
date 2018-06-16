<?php

namespace Core;

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

//            if (isset($_GET["locale"])) {
//				if ($_GET["locale"] == "nl") {
//					$locale = "nl_NL";
//				} else {
//					$locale = "en_US";
//				}
//			} else if (isset($_SESSION["locale"])) {
//				if ($_SESSION["locale"] == "nl") {
//					$locale = "nl_NL";
//				} else {
//					$locale = "en_US";
//				}
//			} else {
//				$lang = "nl_NL";
//				$locale = sprintf("%s.utf-8", $lang);
//			}

			// Even een test door de taal automatisch te selecteren
			//Eerste locale op engels zetten omdat je anders niet weet of het werkt
			$locale = "en_US";
			//Nu de locale vinden op basis van http accept=language header
			$locale = locale_accept_from_http($_SERVER['HTTP_ACCEPT_LANGUAGE']);

            $domain = "messages";
            $lpath = realpath((dirname(__DIR__)) . DIRECTORY_SEPARATOR . "locale");

            putenv("LANGUAGE=" . $locale);
            setlocale(LC_ALL, $locale);
            bindtextdomain($domain, $lpath);
            textdomain($domain);
        }

        echo $twig->render($template, $args);
    }
}
