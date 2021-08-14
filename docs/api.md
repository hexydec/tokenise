# Tokenise API

The tokenise object is fairly easy to configure, the complexity is only in the regular expression patterns that you will capture your tokens with.

## `__construct(array $tokens, string $value)`

Creates a tokenise object

- $tokens - An associative array of regular expressions, where the key is the token type, and the value is the pattern (Note: patterns should not capture any sub-pattern, and should not be delimited)
- $value - The code to be analysed

## `prev(int $decrement = 1)`

Get the previous token (if available), only two previous tokens are kept unless the `$delete` argument is set to `false` when the pointer is moved forward using `next()`

Returns an array containing two keys: `type` which contains the key of the patterns that matched the token, and `value` which contains the captured token value, or null if the token doesn't exist.

#### `$decrement`

An integer specifying how many tokens back to rewind the pointer. Note that only two previous tokens are remembered unless `$delete` was set to `false` on previous calls to `next()`.

## `current()`

Retrieves the current token.

Returns an array containing two keys: `type` which contains the key of the patterns that matched the token, and `value` which contains the captured token value, or null if the token doesn't exist.

## `next(string $pattern = null, bool $delete = true)`

Retrieves the next token:

#### `$pattern`

To capture the next token with a custom regular expression, specify it here.

#### `$delete`

Denotes whether to delete previous tokens, set to `false` to look ahead and retain the ability to look back.

## `rewind(int $chars, ?string $type = null)`

Rewind the pointer and rewrite the last token, so you can start parsing again from a previous position. Note the last token will also be rewritten from where it started to the new position.

#### `$chars`

An integer specifying the number of characters to move the pointer back by.

#### `$type`

To replace the type of the last token, specify the new type here, otherwise `null`.
