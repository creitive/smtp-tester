# SMTP Tester

This tool enables quickly testing whether sending email via an SMTP server works on a given server.

It's meant to be run from the command line - it is not safe to make it accessible via a URL, since it has no throttling mechanism, so it could easily be used as a (D)DoS attack vector.

## Installation, configuration, and usage

Just clone the repo somewhere and do a Composer install. Copy `.env.example` into `.env`, and change the settings to reflect your SMTP server configuration, and the other configurable parameters.

After that, just run `php index.php`, and see whether you receive an email, or you get a `var_dump()`ed exception.

## Change Log

Please see the [Change Log](CHANGELOG.md) for more information what has changed recently.

## License

This project is licensed under the MIT license. Please see the [license file](LICENSE.md) for more information.
