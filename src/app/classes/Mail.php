<?php
/**
 * Class responsible for configuring and sending mail by SMTP with PHPMailer
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues
 *
 * @version 1.0
 * @package classes
 */

namespace Cadtreesa\classes;


class Mail
{
  /**
   * Email sending host
   * @var string $hostname
   */
  private static $hostname = APP_ENVIRONMENT["MAIL"]["MAIL_HOSTNAME"];
  /**
   * Username
   * @var string $username
   */
  private static $username = APP_ENVIRONMENT["MAIL"]["MAIL_USERNAME"];
  /**
   * Password for user
   * @var string $password
   */
  private static $password = APP_ENVIRONMENT["MAIL"]["MAIL_PASSWORD"];
  /**
   * Type of authentication
   * @var string $auth
   */
  private static $auth 	 = APP_ENVIRONMENT["MAIL"]["MAIL_AUTH"];
  /**
   * Port access
   * @var string $port
   */
  private static $port 	 = APP_ENVIRONMENT["MAIL"]["MAIL_PORT"];
  /**
   * Email unicode characters
   * @var string $charset
   */
  private static $charset  = APP_ENVIRONMENT["MAIL"]["MAIL_CHARSET"];

  /**
   * Authenticates connection data
   *
   * @see \PHPMailer
   *
   * @return \PHPMailer object
   */
  private static function auth()
  {
    $mail = new \PHPMailer\PHPMailer\PHPMailer;
    $mail->CharSet = self::$charset;
    $mail->SMTPSecure = self::$auth;
    $mail->isSMTP();
    $mail->Host = self::$hostname;
    $mail->Port = self::$port;
    $mail->SMTPAuth = true;
    $mail->Username = self::$username;
    $mail->Password = self::$password;
    return $mail;
  }

  /**
   * Send email
   *
   * @param string Sent by who
   * @param Array  Data message data
   *
   * @return boolean
   */
  public static function send($from, array $data = [])
  {
    $mail = self::auth();
    $mail->isHTML(true);
    $mail->setFrom($from);
    $mail->FromName = $data["from"];
    $mail->addAddress($data["to"]);
    $mail->Body = $data["message"];
    $mail->Subject = $data["subject"];
    $mail->AltBody = "Para ver esse email tenha certeza de estar em um programa que aceiita HTML";
    $mail->MsgHTML($data["message"]);

    return $mail->send();
  }
}
