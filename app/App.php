<?php

namespace BorderStatus;

/**
 * Class App - Main application class to bootstrap another parts
 */
final class App
{
  /**
   * The Singleton's instance is stored in a static field. This field is an
   * array, because we'll allow our Singleton to have subclasses.
   */
  private static $instances = [];

  /**
   * @var stdClass[] Array of application services
   */
  private $services;

  /**
   * Initialize the application
   */
  public static function init()
  {
    $instance = static::instance();

    /**
     * Services definitions and loading
     */
    $instance->services = [
      Services\L10n::class => new Services\L10n,
      Services\Assets::class => new Services\Assets,
      Services\BorderPoints::class => new Services\BorderPoints,
      Services\ACF::class => new Services\ACF,
      Services\Schedule::class => new Services\Schedule,
    ];
  }

  /**
   * The Singleton's constructor should always be private to prevent direct
   * construction calls with the `new` operator.
   */
  protected function __construct()
  {
  }

  /**
   * Singletons should not be cloneable.
   */
  protected function __clone()
  {
  }

  /**
   * Singletons should not be restorable from strings.
   * @throws
   */
  public function __wakeup()
  {
    throw new \Exception("Cannot unserialize a singleton.");
  }

  /**
   * This implementation lets you subclass the Singleton class while keeping
   * just one instance of each subclass around.
   */
  public static function instance(): App
  {
    $class = static::class;

    if (!isset(static::$instances[$class])) {
      static::$instances[$class] = new static;
    }

    return static::$instances[$class];
  }
}
