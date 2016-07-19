<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2015 Jeremy Hicks <jeremy.hicks@gmail.com>
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\DQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * @author Jeremy Hicks <jeremy.hicks@gmail.com>
 * @see https://github.com/beberlei/DoctrineExtensions
 * @see http://stackoverflow.com/a/13482059 for SQLite, PostreSQL, ...
 */
class FieldFunction extends FunctionNode
{

	/** @var Node|null */
	private $field;

	private $values = [];

	public function parse(Parser $parser)
	{
		$parser->match(Lexer::T_IDENTIFIER);
		$parser->match(Lexer::T_OPEN_PARENTHESIS);
		// Do the field.
		$this->field = $parser->ArithmeticPrimary();
		// Add the strings to the values array. FIELD must
		// be used with at least 1 string not including the field.
		$lexer = $parser->getLexer();
		while (count($this->values) < 1 ||
			$lexer->lookahead['type'] != Lexer::T_CLOSE_PARENTHESIS) {
			$parser->match(Lexer::T_COMMA);
			$this->values[] = $parser->ArithmeticPrimary();
		}
		$parser->match(Lexer::T_CLOSE_PARENTHESIS);
	}

	public function getSql(SqlWalker $sqlWalker)
	{
		$query = 'FIELD(';
		$query .= $this->field->dispatch($sqlWalker);
		$query .= ', ';
		for ($i = 0; $i < count($this->values); $i++) {
			if ($i > 0) {
				$query .= ', ';
			}
			$query .= $this->values[$i]->dispatch($sqlWalker);
		}
		$query .= ')';
		return $query;
	}

}
