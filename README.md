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
