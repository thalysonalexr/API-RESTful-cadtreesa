<?php
/**
 * Class responsible for messages in responses
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues/
 *
 * @version 1.0
 * @package classes
 */

namespace Cadtreesa\classes;


 abstract class Message
 {
 	private static $msg = [
		"post" => [
			201 => "Successful registration.",
			500 => "Server error while attempting to insert."
		],
		"get" => [
			200 => "Data returned successfully.",
			404 => "No records found.",
			500 => "Server error while trying to read."
		],
		"put" => [
			200 => "Data successfully updated.",
			500 => "Server error while attempting to upgrade."
		],
		"delete" => [
			500 => "Server error while attempting to delete."
		],
		"*" => [
			200 => [
				"send_mail" => "Email successfully sent.",
				"not_altered" => "No changes were made"
			],
			202 => [
				"forgot_password" => "Request reset by email."
			],
			400 => [
				"invalid_input" => "Invalid parameters."
			],
			401 => [
				"token_invalid" => "Invalid token.",
				"token_error" => "Token error.",
				"token_defined" => "Token not defined in the header of the request.",
				"unauthorized" => "Not authorized."
			],
			403 => [
				"access" => "Access denied.",
				"user_not_found" => "Invalid token. Entity not found.",
				"user_altered" => "User changed. sign in again."
			],
			404 => [
				"find_user" => "User not registered.",
				"error_pass" => "Wrong password.",
				"not_found" => "Not found."
			],
			415 => [
				"unsupported_media" => 'Unsupported media type'
			],
			500 => [
				"error" => "Server error.",
				"error_send" => "Error sending message.",
				"error_access_token" => "Permission not defined in the request token."
			]
		]
	];

	/**
	 * Returns the requested message
	 *
	 * @param string 	$type 			Message Type
	 * @param integer 	$code 			Code in protocol HTTP
	 * @param string 	$description 	Description of message
	 *
	 * @return string
	 */
	public static function get($type = '*', $code, $description = null)
	{
		if (!is_array(self::$msg[$type][$code]))
			return self::$msg[$type][$code];
		elseif ($description != null)
			return self::$msg[$type][$code][$description];
		throw new \Exception("Invalid arguments", 1);		
	}
 }