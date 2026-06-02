<?php

namespace App\Mail\Transport;

use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\MessageConverter;
use Symfony\Component\Mime\Email;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;

class ZeptoMailTransport extends AbstractTransport
{
    private string $apiToken;
    private string $apiHost;

    public function __construct(string $apiToken, string $apiHost = 'api.zeptomail.in', ?EventDispatcherInterface $dispatcher = null, ?LoggerInterface $logger = null)
    {
        parent::__construct($dispatcher, $logger);
        $this->apiToken = $apiToken;
        $this->apiHost = $apiHost;
    }

    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());

        $payload = [
            'from' => [
                'address' => $email->getFrom()[0]->getAddress(),
                'name' => $email->getFrom()[0]->getName() ?: config('mail.from.name', 'Amsukham'),
            ],
            'to' => [],
            'subject' => $email->getSubject(),
        ];

        foreach ($email->getTo() as $to) {
            $payload['to'][] = [
                'email_address' => [
                    'address' => $to->getAddress(),
                    'name' => $to->getName() ?: $to->getAddress(),
                ],
            ];
        }

        if ($email->getCc()) {
            $payload['cc'] = [];
            foreach ($email->getCc() as $cc) {
                $payload['cc'][] = [
                    'email_address' => [
                        'address' => $cc->getAddress(),
                        'name' => $cc->getName() ?: $cc->getAddress(),
                    ],
                ];
            }
        }

        if ($email->getHtmlBody()) {
            $payload['htmlbody'] = $email->getHtmlBody();
        }

        if ($email->getTextBody()) {
            $payload['textbody'] = $email->getTextBody();
        }

        $ch = curl_init("https://{$this->apiHost}/v1.1/email");
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: ' . $this->apiToken,
                'Content-Type: application/json',
                'Accept: application/json',
            ],
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_TIMEOUT => 30,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new \RuntimeException("ZeptoMail cURL error: {$error}");
        }

        if ($httpCode >= 400) {
            $body = json_decode($response, true);
            $msg = $body['message'] ?? $response;
            throw new \RuntimeException("ZeptoMail API error ({$httpCode}): {$msg}");
        }
    }

    public function __toString(): string
    {
        return 'zeptomail';
    }
}
