<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Caching;

use Doctrine\Common;
use Doctrine\ORM;
use Etten\Doctrine\Entities\Cacheable;

class CacheSubscriber implements Common\EventSubscriber
{

	/** @var CacheInvalidator */
	private $invalidator;

	public function __construct(CacheInvalidator $invalidator)
	{
		$this->invalidator = $invalidator;
	}

	public function getSubscribedEvents()
	{
		return [
			ORM\Events::postPersist => 'postChange',
			ORM\Events::postUpdate => 'postChange',
			ORM\Events::postRemove => 'postChange',
		];
	}

	/**
	 * @param Common\Persistence\Event\LifecycleEventArgs $args
	 * @internal
	 */
	public function postChange(Common\Persistence\Event\LifecycleEventArgs $args)
	{
		$object = $args->getObject();

		if ($object instanceof Cacheable) {
			$this->invalidator->invalidate($object);
		}
	}

}
