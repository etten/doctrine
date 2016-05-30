<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine;

use Doctrine\ORM;

class Transaction
{

	/** @var ORM\EntityManager */
	private $em;

	public function __construct(ORM\EntityManager $em)
	{
		$this->em = $em;
	}

	/**
	 * Executes a function in a transaction.
	 *
	 * The function gets passed this EntityManager instance as an (optional) parameter.
	 *
	 * {@link flush} is invoked prior to transaction commit.
	 *
	 * If an exception occurs during execution of the function or flushing or transaction commit,
	 * the transaction is rolled back, the EntityManager closed and the exception re-thrown.
	 *
	 * @param callable $func The function to execute transactionally.
	 * @return mixed The non-empty value returned from the closure or true instead.
	 */
	public function transactional($func)
	{
		return $this->em->transactional($func);
	}

	/**
	 * Starts a transaction by suspending auto-commit mode.
	 * @return void
	 */
	public function begin()
	{
		$this->em->beginTransaction();
	}

	/**
	 * Commits a transaction on the underlying database connection.
	 * @return void
	 */
	public function commit()
	{
		$this->em->commit();
	}

	/**
	 * Performs a rollback on the underlying database connection.
	 * @return void
	 */
	public function rollback()
	{
		$this->em->rollback();
	}

}
