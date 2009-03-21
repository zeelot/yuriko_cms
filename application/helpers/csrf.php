<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * CSRF helper class.
 */

class csrf_Core {

  public static function token()
  {
    if (($token = Session::instance()->get('csrf')) === FALSE)
    {
      Session::instance()->set('csrf', ($token = text::random('alnum', 16)));
    }

    return $token;
  }

  public static function valid($token)
  {
    return ($token === Session::instance()->get('csrf'));
  }

}