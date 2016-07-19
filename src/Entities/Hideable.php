<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities;

interface Hideable
{

	public function isVisible(): bool;

	public function setVisible(bool $visible);

}
