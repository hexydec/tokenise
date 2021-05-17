<?php
use hexydec\tokens\tokenise;

final class tokeniseTest extends \PHPUnit\Framework\TestCase {

	protected $input = '"The quick brown fox jumps over the lazy dog", this is used by typists to warm up (It covers all the letters on the keyboard).';
	protected $output = [
		['type' => 'quotes', 'value' => '"The quick brown fox jumps over the lazy dog"'],
		['type' => 'punctuation', 'value' => ','],
		['type' => 'whitespace', 'value' => ' '],
		['type' => 'word', 'value' => 'this'],
		['type' => 'whitespace', 'value' => ' '],
		['type' => 'word', 'value' => 'is'],
		['type' => 'whitespace', 'value' => ' '],
		['type' => 'word', 'value' => 'used'],
		['type' => 'whitespace', 'value' => ' '],
		['type' => 'word', 'value' => 'by'],
		['type' => 'whitespace', 'value' => ' '],
		['type' => 'word', 'value' => 'typists'],
		['type' => 'whitespace', 'value' => ' '],
		['type' => 'word', 'value' => 'to'],
		['type' => 'whitespace', 'value' => ' '],
		['type' => 'word', 'value' => 'warm'],
		['type' => 'whitespace', 'value' => ' '],
		['type' => 'word', 'value' => 'up'],
		['type' => 'whitespace', 'value' => ' '],
		['type' => 'openbracket', 'value' => '('],
		['type' => 'word', 'value' => 'It'],
		['type' => 'whitespace', 'value' => ' '],
		['type' => 'word', 'value' => 'covers'],
		['type' => 'whitespace', 'value' => ' '],
		['type' => 'word', 'value' => 'all'],
		['type' => 'whitespace', 'value' => ' '],
		['type' => 'word', 'value' => 'the'],
		['type' => 'whitespace', 'value' => ' '],
		['type' => 'word', 'value' => 'letters'],
		['type' => 'whitespace', 'value' => ' '],
		['type' => 'word', 'value' => 'on'],
		['type' => 'whitespace', 'value' => ' '],
		['type' => 'word', 'value' => 'the'],
		['type' => 'whitespace', 'value' => ' '],
		['type' => 'word', 'value' => 'keyboard'],
		['type' => 'closebracket', 'value' => ')'],
		['type' => 'punctuation', 'value' => '.']
	];
	protected $patterns = [
		'quotes' => '"(?:\\\\.|[^\\\\"])*+"',
		'word' => '[A-Za-z]++',
		'punctuation' => '[.,!?]',
		'whitespace' => '\\s++',
		'openbracket' => '\\(',
		'closebracket' => '\\)'
	];

	public function testCanGenerateTokens() {
		$obj = new tokenise($this->patterns, $this->input);
		$i = 0;
		while (($token = $obj->next()) !== null) {
			$this->assertEquals($this->output[$i], $token);

			// test getting the current token
			$token = $obj->current();
			$this->assertEquals($this->output[$i], $token);

			// test getting the previous token
			if ($i) {
				$token = $obj->prev();
				$this->assertEquals($this->output[$i-1], $token);

				// move the pointer back
				$token = $obj->next();
			}

			// tick the output counter
			$i++;
		}
	}

	public function testCanGetPreviousTokens() {
		$obj = new tokenise($this->patterns, $this->input);
		$i = 0;
		while (($token = $obj->next(null, false)) !== null) {
			$this->assertEquals($this->output[$i], $token);

			// test getting the current token
			$token = $obj->current();
			$this->assertEquals($this->output[$i], $token);

			// tick the output counter
			$i++;
		}
		$i--;

		while (($token = $obj->prev()) !== null) {
			$this->assertEquals($this->output[--$i], $token);
		}
	}

	public function testCanUseCustomPatterns() {
		$obj = new tokenise($this->patterns, $this->input);
		$obj->next();
		$obj->next();
		$obj->next();
		$token = $obj->next('/[a-z ]++/i');
		$this->assertEquals('this is used by typists to warm up ', $token[0], 'Custom pattern matched correctly');
	}

	public function testCanRewindPosition() {
		$obj = new tokenise($this->patterns, $this->input);
		$token = $obj->next();
		$len = \mb_strlen($token['value']);
		$obj->rewind($len - 1, 'quote');
		$this->assertEquals(['value' => '"', 'type' => 'quote'], $obj->current(), 'POinter can be rewound and current token rewritten');
		$this->assertEquals(['value' => 'The', 'type' => 'word'], $obj->next(), 'Next token is correct after pointer rewritten');
		$this->assertEquals(['value' => ' ', 'type' => 'whitespace'], $obj->next(), 'Next token is correct after pointer rewritten');
		$this->assertEquals(['value' => 'quick', 'type' => 'word'], $obj->next(), 'Next token is correct after pointer rewritten');
	}
}
