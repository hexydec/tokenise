<?php
declare(strict_types = 1);
namespace hexydec\tokens;

class tokenise {

	/**
	 * @var string $value Stores the subject value to be tokenised
	 */
	protected string $value = '';

	/**
	 * @var string $pattern Stores the regexp pattern to tokenise the string with
	 */
	protected string $pattern = '';

	/**
	 * @var array $keys An array to map the regexp output with the token type
	 */
	protected array $keys = [];

	/**
	 * @var int $pos The position within $value to retrieve the next token from
	 */
	protected int $pos = 0;

	/**
	 * @var int $pointer The current token position
	 */
	protected int $pointer = -1;

	/**
	 * @var array $tokens An array of captured tokens
	 */
	protected array $tokens = [];

	/**
	 * Constructs a new tokeniser object
	 *
	 * @param array $tokens An associative array of token patterns, tokens will be returned with the key specified
	 * @param string $value The string to be tokenised
	 */
	public function __construct(array $tokens, string $value) {

		// compile pattern
		$this->pattern = '/\G('.\implode(')|(', $tokens).')/u';

		// make the keys a 1 based array
		$keys = \array_keys($tokens);
		\array_unshift($keys, 'hexydec');
		unset($keys[0]);
		$this->keys = $keys;

		// store value
		$this->value = $value;
	}

	/**
	 * Retrieves the previous token (Note you can only retrieve the immediately preceeding token, you can't keep going backwards as the previous previous token is deleted when the next token is consumed)
	 *
	 * @param int $decrement The number of positions to move the pointer back
	 * @return array The previous token or null if the token no longer exists
	 */
	public function prev(int $decrement = 1) : ?array {
		$this->pointer -= $decrement;
		return $this->tokens[$this->pointer] ?? null;
	}

	/**
	 * Retrieves the current token
	 *
	 * @return array The currnet token or null if there is no token
	 */
	public function current() : ?array {
		return $this->tokens[$this->pointer] ?? null;
	}

	/**
	 * Retrieves the next token
	 *
	 * @param string $pattern A custom pattern to get the next token, if set will be used in place of the configured token
	 * @param bool $delete Denotes whether to delete previous tokens to save memory
	 * @return array The next token or null if there are no more tokens to retrieve
	 */
	public function next(string $pattern = null, bool $delete = true) : ?array {
		$pointer = $this->pointer + 1;

		// get cached token
		if (isset($this->tokens[$pointer])) {
			return $this->tokens[++$this->pointer];

		// extract next token
		} elseif (\preg_match($pattern ?? $this->pattern, $this->value, $match, PREG_UNMATCHED_AS_NULL, $this->pos)) {
			$this->pos += \strlen($match[0]);

			// custom pattern
			if ($pattern) {
				return $match;

			// go through tokens and find which one matched
			} else {
				foreach ($this->keys AS $i => $key) {
					if ($match[$i] !== null) {

						// save the token
						$token = $this->tokens[++$this->pointer] = [
							'type' => $key,
							'value' => $match[$i]
						];

						// remove previous tokens to lower memory consumption, also makes the program faster with a smaller array to handle
						if ($delete) {
							unset($this->tokens[$pointer - 2]);
						}
						return $token;
					}
				}
			}
		}
		return null;
	}

	/**
	 * Rewind the pointer and rewrite the last token, so you can start parsing again from a previous position. Note the last token will also be rewritten
	 *
	 * @param int $chars The number of characters to rewind
	 * @param string $type If you wish to change the type of the last token, specify the type here
	 * @return void
	 */
	public function rewind(int $chars, ?string $type = null) : void {
		$this->pos -= $chars;
		$pointer = $this->pointer;
		$this->tokens[$pointer]['value'] = \mb_substr($this->tokens[$pointer]['value'], 0, $chars * -1);
		if ($type) {
			$this->tokens[$pointer]['type'] = $type;
		}
	}
}
