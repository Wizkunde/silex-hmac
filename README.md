General information
==========

[![Build Status](https://travis-ci.org/Wizkunde/silex-hmac.png)](https://travis-ci.org/Wizkunde/silex-hmac)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/Wizkunde/silex-hmac/badges/quality-score.png?s=a4560694448130886b3d9754b9e2948b6d9cd5a8)](https://scrutinizer-ci.com/g/Wizkunde/silex-hmac/)
[![Code Coverage](https://scrutinizer-ci.com/g/Wizkunde/silex-hmac/badges/coverage.png?s=693e3823c8ba326fc2ef8fbf5ffb81b9c5f933c9)](https://scrutinizer-ci.com/g/Wizkunde/silex-hmac/)

This code will provide an easy interface to add a HMAC verification to your project

It relies on 3 HTTP headers:

HTTP_KEY, HTTP_WHEN and HTTP_URI

HTTP_KEY contains your own generated HMAC key
HTTP_WHEN contains a timestamp to the second that you created the HMAC
HTTP_URI is the uri that you are using to create your request

The request may not be older than 5 minutes.

Installation
==========

Add the git repo to your composer.json
