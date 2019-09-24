<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Express\Action;

use Assert\AssertionFailedException;
use Ixocreate\Admin\Response\ApiErrorResponse;
use Ixocreate\Application\Config\Config;
use Ixocreate\Schema\Type\EmailType;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class ContactAction implements MiddlewareInterface
{
    /**
     * @var Config
     */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $data = $request->getParsedBody();
        if (!\is_array($data)
            || empty($data['firstName'])
            || empty($data['lastName'])
            || empty($data['email'])
            || empty($data['message'])
            || empty($data['privacy'])
            || $data['privacy'] != 'on'
        ) {
            return new ApiErrorResponse("*", ["error.invalid_data"]);
        }

        try {
            $mail = (new EmailType())->create($data['email']);
        } catch (AssertionFailedException $e) {
            return new ApiErrorResponse("*", ["error.invalid_email"]);
        }

        try {
            $subject = 'Contact Form - ' . $data['firstName'] . ' ' . $data['lastName'];

            $body = "Contact Form \n\n";

            $body .= ($data['gender'] == 'm') ? 'Mr. ' : 'Mrs. ';
            $body .= $data['firstName'] . ' ' . $data['lastName'] . "\n\n";
            $body .= "Email: {$data['email']}\n";
            $body .= "Phone: {$data['phone']}\n";
            $body .= "Fax: {$data['fax']}\n\n";
            $body .= "{$data['street']} {$data['streetNumber']}\n";
            $body .= "{$data['zip']} {$data['city']}\n";
            $body .= "{$data['country']}\n\n";

            $body .= "Message:\n{$data['message']}";

            $message = (new \Swift_Message($subject))
                ->setFrom($this->config->get('mail.from'))
                ->setTo([$this->config->get('mail.to')])
                ->setReplyTo($data['email'])
                ->setBody($body);

            $transport = $this->getTransport();

            (new \Swift_Mailer($transport))->send($message);
        } catch (\Exception $e) {
            return new ApiErrorResponse("*", ["error.smtp_error"]);
        }
        return new JsonResponse(['success' => true]);
    }

    public function getTransport()
    {
        $transport = new \Swift_SmtpTransport($this->config->get('mail.server'), $this->config->get('mail.port', 25), $this->config->get('mail.encryption', 'tls'));
        $transport->setStreamOptions(['ssl' => ['verify_peer' => $this->config->get('mail.verify_peer', true), 'verify_peer_name' => $this->config->get('mail.verify_peer', true)]]);
        $transport
            ->setUsername('contact-form')
            ->setPassword('contact-form');
        return $transport;
    }
}
