<?php

require 'vendor/autoload.php';

/**
 * Load sensitive environment configuration.
 */
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

/**
 * Parameters for connecting to the SMTP server.
 *
 * @var array
 */
$smtpParameters = [
    'username' => getenv('SMTP_USERNAME'),
    'password' => getenv('SMTP_PASSWORD'),
    'server' => getenv('SMTP_SERVER'),
    'port' => getenv('SMTP_PORT'),
    'protocol' => getenv('SMTP_PROTOCOL'),
];

/**
 * Parameters for the test message.
 *
 * @var array
 */
$messageParameters = [
    'from' => [
        'email' => getenv('FROM_EMAIL'),
        'name' => getenv('FROM_NAME'),
    ],
    'to' => [
        'email' => getenv('TO_EMAIL'),
        'name' => getenv('TO_NAME'),
    ],
    'subject' => getenv('EMAIL_SUBJECT'),
    'body' => [
        'html' => getenv('EMAIL_BODY_HTML'),
        'plain' => getenv('EMAIL_BODY_PLAIN'),
    ],
];

/*
 * Construct the SMTP transport with the provided credentials.
 */
$transport = Swift_SmtpTransport::newInstance($smtpParameters['server'], $smtpParameters['port'], $smtpParameters['protocol'])
    ->setUsername($smtpParameters['username'])
    ->setPassword($smtpParameters['password'])
;

/*
 * Instantiate a mailer with the SMTP transport.
 */
$mailer = Swift_Mailer::newInstance($transport);

/*
 * Construct an email message with the provided data.
 */
$message = Swift_Message::newInstance()
    ->setMaxLineLength(1000)
    ->setSubject($messageParameters['subject'])
    ->setBody($messageParameters['body']['html'], 'text/html')
    ->addPart($messageParameters['body']['plain'], 'text/plain')
    ->setFrom([$messageParameters['from']['email'] => $messageParameters['from']['name']])
    ->setTo([$messageParameters['to']['email'] => $messageParameters['to']['name']]);

try
{
    $mailer->send($message);

    echo "Email sent successfully!\n";

    exit(0);
}
catch (Swift_SwiftException $exception)
{
    /*
     * This is how we roll.
     */

    echo "Email sent unsuccessfully, exception dump below:\n";

    var_dump($exception);

    exit(1);
}
