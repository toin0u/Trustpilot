Trustpilot
==========

This PHP 5.3+ library helps you to interact with the [Trustpilot Developer Feed](http://trustpilot.github.com/developers/).

[![Build Status](https://secure.travis-ci.org/toin0u/Trustpilot.png)](http://travis-ci.org/toin0u/Trustpilot)
[![project status](http://stillmaintained.com/toin0u/Trustpilot.png)](http://stillmaintained.com/toin0u/Trustpilot)

Installation
------------

This library can be found on [Packagist](https://packagist.org/packages/toin0u/trustpilot).
The recommended way to install this is through [composer](http://getcomposer.org).

Run these commands to install composer, the library and its dependencies:

```bash
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar require toin0u/trustpilot:@stable
```

Now you can add the autoloader, and you will have access to the library:

```php
<?php

require 'vendor/autoload.php';
```

If you don't use neither **Composer** nor a _ClassLoader_ in your application, just require the provided autoloader:

```php
<?php

require_once 'src/autoload.php';
```

Usage
-----

You need an `HttpAdapter` which is responsible to get data from Trustpilot Feed.
You can provide your own adapter by implementing `\Trustpilot\HttpAdapter\HttpAdapterInterface`.

Currently, only `CurlHttpAdapter` is available - it's the default one.

```php
<?php
require 'vendor/autoload.php';

use Trustpilot\Trustpilot;

$trustpilot = new Trustpilot(917278);

try {
    printf("Last update: %s\n", $trustpilot->getLastUpdate()->getHuman());
    printf("Domain name: %s\n", $trustpilot->getDomainName());
    printf("Page url: %s\n", $trustpilot->getUrl());
    printf("Total reviews: %u\n", $trustpilot->getTotalReviews());
    printf("- 1: %u\n", $trustpilot->getDistributionOverStars()[0]);
    printf("- 2: %u\n", $trustpilot->getDistributionOverStars()[1]);
    printf("- 3: %u\n", $trustpilot->getDistributionOverStars()[2]);
    printf("- 4: %u\n", $trustpilot->getDistributionOverStars()[3]);
    printf("- 5: %u\n", $trustpilot->getDistributionOverStars()[4]);

    $trustscore = $trustpilot->getTrustScore();
    printf("Trust Score (between 0 and 100): %u\n", $trustscore->getScore());
    printf("Trust Score in stars (between 1 and 5): %u\n", $trustscore->getStars());
    printf("Trust Score: %s\n", $trustscore->getReadableScore());

    $reviews = $trustpilot->getReviews(); // an array of Review object
    // ... see below

    $categories = $trustpilot->getCategories(); // an array of Category object
    // ... see below
} catch (Exception $e) {
    die($e->getMessage());
}
```

You will get someting like:

```
Last update: 05 April 2013 12:14:17 GMT
Domain name: demoshop.com
Page url: http://www.trustpilot.co.uk/review/demoshop.com
Total reviews: 105
- 1: 3
- 2: 1
- 3: 11
- 4: 28
- 5: 62
```


API
---

### Category ###

TODO

### Time ###

TODO

### TrustScore ###

TODO

### User ###

TODO

### Review ###

TODO


Unit Tests
----------

To run unit tests, you'll need `cURL` and `zlib` extensions and a set of dependencies,
you can install them using Composer:

```bash
$ php composer.phar install --dev
```

Once installed, just launch the following command:

```bash
$ phpunit --coverage-text
```


Contributing
------------

Please see [CONTRIBUTING](https://github.com/toin0u/Trustpilot/blob/master/CONTRIBUTING.md) for details.


Credits
-------

* [Antoine Corcy](https://twitter.com/toin0u) - Owner
* [All contributors](https://github.com/toin0u/Trustpilot/contributors)


Changelog
---------

[See the changelog file](https://github.com/toin0u/Trustpilot/blob/master/CHANGELOG.md)


Support
-------

[Please open an issues in github](https://github.com/toin0u/Trustpilot/issues)


License
-------

Trustpilot is released under the MIT License. See the bundled
[LICENSE](https://github.com/toin0u/Trustpilot/blob/master/LICENSE) file for details.
