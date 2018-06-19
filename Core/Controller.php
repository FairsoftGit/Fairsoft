<?php

namespace Core;

use App\Config;
use \App\Models\Language;

/**
 * Base controller
 *
 * PHP version 7.0
 */
abstract class Controller
{
    /**
     * Parameters from the matched route
     * @var array
     */
    protected $route_params = [];

    /**
     * Class constructor
     *
     * @param array $route_params Parameters from the route
     *
     * @return void
     */
    public function __construct($route_params)
    {
        $this->route_params = $route_params;
        $this->setLanguageDefaults();
    }

    private function setLanguageDefaults()
    {
        if(is_null(Session::get('available_languages')))
        {
            Session::set('available_languages', Language::getAvailable());
        }
        if(is_null(Session::get('locale')))
        {
            $browserLanguage = $this->getLanguageByCode(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
            Session::set('locale', ($browserLanguage) ? $browserLanguage->getLocale() : Config::DEFAULT_LOCALE);
        }
    }

    protected function getLanguageByCode($code)
    {
        $available_languages = Session::get('available_languages');
        foreach ($available_languages as $language) {
            if ($language->getCode() === $code) {
                return $language;
            }
        }
        return null;
    }

    protected function isAuthenticated()
    {
        if (is_null(Session::get('account'))) {
            return false;
        }
        return true;
    }

    /**
     * Magic method called when a non-existent or inaccessible method is
     * called on an object of this class. Used to execute before and after
     * filter methods on action methods. Action methods need to be named
     * with an "Action" suffix, e.g. indexAction, showAction etc.
     *
     * @param string $name Method name
     * @param array $args Arguments passed to the method
     *
     * @return void
     */
    public function __call($name, $args)
    {
        $method = $name . 'Action';

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            throw new \Exception("Method $method not found in controller " . get_class($this));
        }
    }

    /**
     * Before filter - called before an action method.
     *
     * @return void
     */
    protected function before()
    {
    }

    /**
     * After filter - called after an action method.
     *
     * @return void
     */
    protected function after()
    {
    }
}
