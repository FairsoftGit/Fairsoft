<?php
/**
 * Created by PhpStorm.
 * User: JustinR
 * Date: 17-5-2018
 * Time: 14:58
 */

class Post
{

    /* TODO
     *
     *  1. make two projects: one with static methods, the other without
     *  2. pros and cons?
     *  3. in both versions:
     *    - add function set(key, value)
     *    - add function clear(key = null), null means clear all
     *  4. what about session_start()?
     *  5. what about session_name()?
     *  6. write the classes Post, Get and Server in a similar way (see fragment below)
     *  7. put every class in its own file: Session.php, Post.php ...
     *  8. move the class files into a folder called 'system'
     *  9. use PHPDoc or something similar
     * 10. write a form (post) plus handler using the Post class
     *     with FILTER_VALIDATE_EMAIL as 3rd parameter to get()
     * 11. write tests for all methods

     */



    /**
     * ...
     * @param type $key
     * @param type $filter
     * @param type $options
     * @return type
     */

    public static function get($key, $filter = null, $options = null, $default = null) {
        $value = filter_input(INPUT_POST, $key, $filter, $options);
        if($value === FALSE) {
            return $default;
        }
        return $value;
    }
}