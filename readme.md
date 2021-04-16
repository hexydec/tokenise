# Tokenise: A Regexp Based PHP Tokeniser

A program for performing lexical analysis, written in PHP. Designed to supply tokens to a parser in order to analyse the syntax of programming languages.

## Description

Using an array of regular expressions, tokens are extracted from the input code in sequence and upon request. Previous tokens can also be re-requested, and custom regular expressions can also be used to retrieve the next token.

Currently used in my other projects:

- [HTMLdoc: PHP HTML Document Parser and Minifier](http://githubcom/hexydec/htmldoc)
- [CSSdoc: PHP CSS Document Parser and Minifier]((http://githubcom/hexydec/cssdoc)
- [JSlite: PHP Javascript Minifier]((http://githubcom/hexydec/jslite)

## Usage

Basic usage within a program:

```php
$obj = new \hexydec\tokens\tokenise($tokens, $value);

while (($token = $obj->next()) !== null) {
	// parse each token
}
```

### __construct(array $tokens, string $value)

Creates a tokenise object

- $tokens - An associative array of regular expressions, where the key is the token type, and the value is the pattern (Note: patterns should not capture any sub-pattern, and should not be delimited)
- $value - The code to be analysed

### prev()

Get the previous token (if available), only two previous tokens are kept unless the `$delete` argument is set to `false` when the pointer is moved forward using `next()`

Returns an array containing two keys: `type` which cantains the key of the patterns that matched the token, and `value` which contains the captured token value, or null if the token doesn't exist.

### current()

Retrieves the current token.

Returns an array containing two keys: `type` which cantains the key of the patterns that matched the token, and `value` which contains the captured token value, or null if the token doesn't exist.

### next(string $pattern = null, bool $delete = true)

Retrieves the next token:

- $pattern - To capture the next token with a custom regular expression, specify it here
- $delete - Denotes whether to delete previous tokens, set to `false` to look ahead and retain the ability to look back

## Contributing

If you find an issue with tokenise, please create an issue in the tracker.

If you wish to fix an issue yourself, please fork the code, fix the issue, then create a pull request, and I will evaluate your submission.

## Licence

The MIT License (MIT). Please see [License File](LICENCE) for more information.
