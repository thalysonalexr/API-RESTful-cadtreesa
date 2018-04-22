<?php
/**
 * Configuration class
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues
 *
 * @version 1.0
 * @package classes
 */

namespace Cadtreesa\classes;


abstract class Cfg
{
  /**
   * Alias for DIRECTORY_SEPARATOR \ OR /
   *
   * @type string
   */
  const DS = DIRECTORY_SEPARATOR;
  /**
   * Path complete of application
   *
   * @type string
   */
  const ROOT = __DIR__ . self::DS . ".." . self::DS . "..";
  /**
   * Directory of configuration
   *
   * @type string
   */
  const CONFIG = "config";
  /**
   * File of configuration must be development, production or testing. See in directory config
   *
   * @type string
   */
  const FILE = self::ROOT . self::DS . self::CONFIG . self::DS . "development.ini";
}
