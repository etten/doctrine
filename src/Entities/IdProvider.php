<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities;

interface IdProvider
{

	/**
	 * @return mixed
	 */
	public function getId();

	/**
	 * @return string
	 */
	public function getHexId();

}
