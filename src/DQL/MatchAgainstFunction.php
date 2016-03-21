<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\DQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * @see http://stackoverflow.com/a/17536071/4827632
 * MatchAgainstFunction ::=
 *  "MATCH" "(" StateFieldPathExpression {"," StateFieldPathExpression}* ")" "AGAINST" "("
 *      StringPrimary ["BOOLEAN"] ["EXPAND"] ")"
 */
class MatchAgainstFunction extends FunctionNode
{

	/** @var array list of \Doctrine\ORM\Query\AST\PathExpression */
	private $pathExp = NULL;

	/** @var string */
	private $against = NULL;

	/** @var boolean */
	private $booleanMode = FALSE;

	/** @var boolean */
	private $queryExpansion = FALSE;

	public function parse(Parser $parser)
	{
		// match
		$parser->match(Lexer::T_IDENTIFIER);
		$parser->match(Lexer::T_OPEN_PARENTHESIS);

		// first Path Expression is mandatory
		$this->pathExp = [];
		$this->pathExp[] = $parser->StateFieldPathExpression();

		// Subsequent Path Expressions are optional
		$lexer = $parser->getLexer();
		while ($lexer->isNextToken(Lexer::T_COMMA)) {
			$parser->match(Lexer::T_COMMA);
			$this->pathExp[] = $parser->StateFieldPathExpression();
		}

		$parser->match(Lexer::T_CLOSE_PARENTHESIS);

		// against
		if (strtolower($lexer->lookahead['value']) !== 'against') {
			$parser->syntaxError('against');
		}

		$parser->match(Lexer::T_IDENTIFIER);
		$parser->match(Lexer::T_OPEN_PARENTHESIS);
		$this->against = $parser->StringPrimary();

		if (strtolower($lexer->lookahead['value']) === 'boolean') {
			$parser->match(Lexer::T_IDENTIFIER);
			$this->booleanMode = TRUE;
		}

		if (strtolower($lexer->lookahead['value']) === 'expand') {
			$parser->match(Lexer::T_IDENTIFIER);
			$this->queryExpansion = TRUE;
		}

		$parser->match(Lexer::T_CLOSE_PARENTHESIS);
	}

	public function getSql(SqlWalker $walker)
	{
		$fields = [];
		foreach ($this->pathExp as $pathExp) {
			$fields[] = $pathExp->dispatch($walker);
		}

		$against = $walker->walkStringPrimary($this->against)
			. ($this->booleanMode ? ' IN BOOLEAN MODE' : '')
			. ($this->queryExpansion ? ' WITH QUERY EXPANSION' : '');

		return sprintf('MATCH (%s) AGAINST (%s)', implode(', ', $fields), $against);
	}

}
