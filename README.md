Trustpilot
==========

**Please note that the JSON feed has been [discontinued](https://github.com/trustpilot/developers/issues/27#issuecomment-75207809)**

This PHP 5.3+ library helps you to interact with the [Trustpilot Developer Feed](http://trustpilot.github.com/developers/).

[![Build Status](https://secure.travis-ci.org/toin0u/Trustpilot.png)](http://travis-ci.org/toin0u/Trustpilot)
[![Coverage Status](https://coveralls.io/repos/toin0u/Trustpilot/badge.png?branch=master)](https://coveralls.io/r/toin0u/Trustpilot)
[![Latest Stable Version](https://poser.pugx.org/toin0u/trustpilot/v/stable.png)](https://packagist.org/packages/toin0u/trustpilot)
[![Total Downloads](https://poser.pugx.org/toin0u/trustpilot/downloads.png)](https://packagist.org/packages/toin0u/trustpilot)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/0474417b-27ab-4116-a911-442fbf5970ea/mini.png)](https://insight.sensiolabs.com/projects/0474417b-27ab-4116-a911-442fbf5970ea)


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

First of all, you can set up a cache object which will cache your feed. There is no default cache and currently
there is only `\Trustpilot\Cache\File`. You can provide your own cache by implementing
`\Trustpilot\Cache\CacheInterface`.

* **File cache** (you need to install Symfony Finder and Filesystem components)
    * `File($cacheTimeLimit = self::CACHE_TIME_LIMIT, $temporaryFolderName = self::TEMPORARY_FOLDER_NAME)`
    * `$cacheTimeLimit` must be something that strtotime() is able to parse, '> now - 3 hours' is set by default.
    * `$temporaryFolderName` must be a string, 'trustpilot' is set by default.

You need an `HttpAdapter` which is responsible to get data from Trustpilot Feed.
You can provide your own adapter by implementing `HttpAdapter\HttpAdapterInterface`.

[Read more about HttpAdapter](https://github.com/toin0u/HttpAdapter)

```php
<?php

require 'vendor/autoload.php';

use Trustpilot\Trustpilot;
use Trustpilot\Cache\File;
use HttpAdapter\CurlHttpAdapter;

$cache      = new File('> now - 1 hour', 'my_temporary_folder'); // optional
$adapter    = new CurlHttpAdapter(); // the default one
$trustpilot = new Trustpilot(917278, $cache, $adapter);

try {
    printf("Last update: %s\n", $trustpilot->getLastUpdate()->getHuman());
    printf("Domain name: %s\n", $trustpilot->getDomainName());
    printf("Page url: %s\n", $trustpilot->getUrl());
    printf("Total reviews: %u\n", $trustpilot->getTotalReviews());

    $distributionOverStars = $trustpilot->getDistributionOverStars();
    printf("- 1: %u\n", $distributionOverStars[0]);
    printf("- 2: %u\n", $distributionOverStars[1]);
    printf("- 3: %u\n", $distributionOverStars[2]);
    printf("- 4: %u\n", $distributionOverStars[3]);
    printf("- 5: %u\n", $distributionOverStars[4]);

    printf("Trust Score (between 0 and 100): %u\n", $trustpilot->getTrustScore()->getScore());
    printf("Trust Score in stars (between 1 and 5): %u\n", $trustpilot->getTrustScore()->getStars());
    printf("Trust Score: %s\n", $trustpilot->getTrustScore()->getReadableScore());
    printf("Trust Score image url: %s\n", $trustpilot->getTrustScore()->getImageUrl('medium'));

    foreach ($trustpilot->getReviews() as $review) {
        printf("Review date: %s\n", $review->getTime()->getDateTime()->format('Y-m-d H:i:s'));
        printf("Review title: %s\n", $review->getTitle());
        printf("Review content: %s\n", $review->getContent());
        printf("Review company reply: %s\n", $review->getCompanyReply());
        printf("Review url: %s\n", $review->getUrl());
        printf("Review verified: %s\n", $review->isVerified() ? 'yes' : 'no');
        printf("Review Trust Score (between 0 and 100): %u\n", $review->getTrustScore()->getScore());
        printf("Review Trust Score in stars (between 1 and 5): %u\n", $review->getTrustScore()->getStars());
        printf("Review Trust Score: %s\n", $review->getTrustScore()->getReadableScore());
        printf("Review Trust Score image url: %s\n", $review->getTrustScore()->getImageUrl('medium'));
        printf("Review user name: %s\n", $review->getUser()->getName());
        printf("Review user city: %s\n", $review->getUser()->getCity());
        printf("Review user locale: %s\n", $review->getUser()->getLocale());
        printf("Review user total reviews: %u\n", $review->getUser()->getTotalReviews());
        printf("Review user verified: %s\n", $review->getUser()->isVerified() ? 'yes' : 'no');
        printf("Review user profile image: %s\n", $review->getUser()->hasImage() ? 'yes' : 'no');
        printf("Review user profile image url: %s\n", $review->getUser()->getImageUrl('i35'));
    }

    foreach ($trustpilot->getCategories() as $category) {
        printf("Category name: %s\n", $category->getName());
        printf("Category position: %u\n", $category->getPosition());
        printf("Category total domains: %u\n", $category->getTotalDomain());
        printf("Category position image url: %s\n", $category->getImageUrl('i280'));
    }
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
Trust Score (between 0 and 100): 84
Trust Score in stars (between 1 and 5): 4
Trust Score: Good
Review date: 2013-03-07 13:58:36
Review title: Testing testing
Review content: Testing like a boss!!!!
Review company reply:
Review url: http://www.trustpilot.co.uk/review/demoshop.com#3943492
Review verified: no
Review Trust Score (between 0 and 100): 100
Review Trust Score in stars (between 1 and 5): 5
Review Trust Score: Excellent
Review Trust Score image url: //s3-eu-west-1.amazonaws.com/s.trustpilot.com/images/tpelements/stars/m/5.png
Review user name: Jacob Mortensen
Review user city: Amager
Review user locale: da-DK
Review user total reviews: 2
Review user verified: no
Review user profile image: yes
Review user profile image url: //s3-eu-west-1.amazonaws.com/images.trustpilot.com/CloudImages/User/881929/35x35.png
...
Category name: Accounting
Category position: 3
Category total domains: 7
Category position image url: //s3-eu-west-1.amazonaws.com/s.trustpilot.com/images/tpelements/category_badge/en_280_3.png
Category name: Bags and Luggage
Category position: 7
Category total domains: 21
Category position image url: //s3-eu-west-1.amazonaws.com/s.trustpilot.com/images/tpelements/category_badge/en_280_10.png
```


API
---

### Trustpilot ###

* `getDomainName()`: The name of the domain. E.g. "demoshop.com".
* `getLastUpdate()`: The time this feed was generated which is a `Trustpilot\Time\Time` object.
* `getUrl()`: The url for the review page of this domain on Trustpilot.
* `getTotalReviews()`: The total number of reviews of this domain, `integer`.
* `getDistributionOverStars()`: An array
* `getReviews()`: A list of up to 10 reviews of this domain. These reviews are selected by:
    * The reviews that the administrator of the domain have selected for the feed
    * Select from the remaining reviews, order by rating descending, then by date descending
    * It's an array of `Trustpilot\Review\Review` objects.
* `getCategories()`: The categories of this domain.
    * May contain zero to multiple elements.
    * It's an array of `Trustpilot\Category\Category` objects.
* `getTrustScore()`: The score of this domain which is a `Trustpilot\TrustScore\TrustScore` object.

### Category ###

* `getName()`: The name of the category localized to the language of the domain.
* `getPosition()`: The position in the category, `integer`.
* `getTotalDomain()`: The amount of domains in the category, `integer`.
* `getImageUrl($size = 'i100')`: The image in different sizes and can be found with the argument,
`i100`, `i120`, `i140`, `i180`, `i220` and `i280` for the six different pixel sizes.

### Time ###

* `getDateTime()`: The `\DateTime` object.
* `getHuman()`: A human readable representation of the time localized to the language of the domain.
E.g. `4 October 2011 10:16:52 GMT`
* `getUnixTime()`: The number of seconds since January 1st, 1970 to this time, `integer`.
* `getHumanDate()`: A human readable representation of the date part of the time localized to the language of the domain.
E.g. `15. Oct

### TrustScore ###

* `getScore()`: A score from 0 to 100, `integer`.
* `getStars()`: A number of start from 1 to 5, `integer`.
* `getReadableScore()`: A description of the score, localized to the language of the domain.
E.g. `Excellent` or `Good`.
* `getImageUrl($size = 'small')`: The image that shows the number of stars.
It comes in three different sizes which can be found on the arguments `small`, `medium`, and `large`.

### User ###

* `getName()`: The name of the user.
* `getCity()`: The city of the user if any, null otherwise.
* `getLocale()`: The locale or culture of the user. E.g. "en-GB" for British.
* `getTotalReviews()`: The total number of reviews written by this user, `integer`.
* `isVerified()`: True if the user is verified, false otherwise.
* `hasImage()`:  True if the user have a profile image, false otherwise.
* `getImageUrl($size = 'i24')`: The image url of the profile image.
If the user does not have a profile picture, the url will point to a default profile image.
The sizes can be found on these arguments: `i24`, `i35`, `i64` and `i73`.

### Review ###

* `getTime()`: The creation date of the review which is a `Trustpilot\Time\Time` object.
* `getTitle()`: The title of the review.
* `getContent()`: The main content of the review.
* `getTrustScore()`: The `Trustpilot\TrustScore\TrustScore` object.
* `getCompanyReply()`: The company reply of this review if any, null otherwise.
* `getUser()`: The author of the review which is a `Trustpilot\User\User` object.
* `getUrl()`: The url to the review.
* `isVerified()`: True if this review is verified, false otherwise.


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

* [Antoine Corcy](https://twitter.com/toin0u)
* [All contributors](https://github.com/toin0u/Trustpilot/contributors)


Acknowledgments
---------------
* [Symfony Finder Component](https://github.com/symfony/Finder) -
[MIT](https://raw.github.com/symfony/Finder/master/LICENSE)
* [Symfony Filesystem Component](https://github.com/symfony/Filesystem) -
[MIT](https://raw.github.com/symfony/Filesystem/master/LICENSE)


Changelog
---------

[See the changelog file](https://github.com/toin0u/Trustpilot/blob/master/CHANGELOG.md)


Support
-------

[Please open an issues in github](https://github.com/toin0u/Trustpilot/issues)


Contributor Code of Conduct
---------------------------

As contributors and maintainers of this project, we pledge to respect all people
who contribute through reporting issues, posting feature requests, updating
documentation, submitting pull requests or patches, and other activities.

We are committed to making participation in this project a harassment-free
experience for everyone, regardless of level of experience, gender, gender
identity and expression, sexual orientation, disability, personal appearance,
body size, race, age, or religion.

Examples of unacceptable behavior by participants include the use of sexual
language or imagery, derogatory comments or personal attacks, trolling, public
or private harassment, insults, or other unprofessional conduct.

Project maintainers have the right and responsibility to remove, edit, or reject
comments, commits, code, wiki edits, issues, and other contributions that are
not aligned to this Code of Conduct. Project maintainers who do not follow the
Code of Conduct may be removed from the project team.

Instances of abusive, harassing, or otherwise unacceptable behavior may be
reported by opening an issue or contacting one or more of the project
maintainers.

This Code of Conduct is adapted from the [Contributor
Covenant](http:contributor-covenant.org), version 1.0.0, available at
[http://contributor-covenant.org/version/1/0/0/](http://contributor-covenant.org/version/1/0/0/)


License
-------

Trustpilot is released under the MIT License. See the bundled
[LICENSE](https://github.com/toin0u/Trustpilot/blob/master/LICENSE) file for details.

[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/toin0u/Trustpilot/trend.png)](https://bitdeli.com/free "Bitdeli Badge")
