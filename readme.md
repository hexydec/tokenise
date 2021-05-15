# Tokenise: A Regexp Based PHP Tokeniser

A program for performing lexical analysis, written in PHP. Designed to supply tokens to a parser in order to analyse the syntax of programming languages.

![Licence](https://img.shields.io/badge/Licence-MIT-lightgrey.svg)
![Status: Beta](https://img.shields.io/badge/Status-Beta-Yellow.svg)
[![Tests Status](https://github.com/hexydec/tokenise/actions/workflows/tests.yml/badge.svg)](https://github.com/hexydec/tokenise/actions/workflows/tests.yml)
[![Code Coverage](https://codecov.io/gh/hexydec/tokenise/branch/master/graph/badge.svg)](https://app.codecov.io/gh/hexydec/tokenise)

## Description

Using an array of regular expressions, tokens are extracted from the input code in sequence and upon request. Previous tokens can also be re-requested, and custom regular expressions can also be used to retrieve the next token.

Currently used in my other projects:

- [HTMLdoc: PHP HTML Document Parser and Minifier](http://githubcom/hexydec/htmldoc)
- [CSSdoc: PHP CSS Document Parser and Minifier](http://githubcom/hexydec/cssdoc)
- [JSlite: PHP Javascript Minifier](http://githubcom/hexydec/jslite)

## Usage

Basic usage within a program:

```php
$obj = new \hexydec\tokens\tokenise($tokens, $value);

while (($token = $obj->next()) !== null) {
	// parse each token
}
```

## API

For more detailed usage documentation, [read the API document](docs/api.md).

## Contributing

If you find an issue with tokenise, please create an issue in the tracker.

If you wish to fix an issue yourself, please fork the code, fix the issue, then create a pull request, and I will evaluate your submission.

## Licence

The MIT License (MIT). Please see [License File](LICENCE) for more information.
