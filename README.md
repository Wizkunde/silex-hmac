General information
==========

[![Build Status](https://travis-ci.org/Wizkunde/silex-hmac.png)](https://travis-ci.org/Wizkunde/silex-hmac)

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
