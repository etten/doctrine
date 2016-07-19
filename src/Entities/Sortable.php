<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities;

interface Sortable extends \Gedmo\Sortable\Sortable
{

	public function getPosition(): int;

	public function setPosition(int $position);

}
