<?php
/**
 * Send emails by POST
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues
 *
 * @version 1.0
 * @package Controllers\Mail\Post
 */

namespace Cadtreesa\Controllers\Mail\Post;


use Cadtreesa\Validation\MailValidator;
use Cadtreesa\classes\Mail;
use Cadtreesa\classes\Json;
use Cadtreesa\classes\Response;
use Cadtreesa\classes\Message as m;
use Respect\Rest\Routable;


class Post implements Routable
{
    public function post()
    {
        $data = Json::verify();
        $validate = (object) MailValidator::validate($data);
        
        if ($validate->success) {

            if (Mail::send($data->email,
            [
                "from"    => $data->name,
                "to"      => APP_ENVIRONMENT["MAIL"]["MAIL_TO"],
                "subject" => $data->subject,
                "message" => $data->message
            ]))
                return Response::json(200, m::get('*', 200, 'send_mail'));
            
            return Response::json(500, m::get('*', 500, 'error_send'));
            
        }
        return Response::json(400, m::get('*', 400, 'invalid_input'), $validate->log);
    }
}