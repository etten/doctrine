<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Console;

use Kdyby\Doctrine;

class SchemaDropCommand extends Doctrine\Console\SchemaDropCommand
{

	use ExecuteSchemaCommandTrait;

}
