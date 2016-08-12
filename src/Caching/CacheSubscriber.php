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
			ORM\Events::postPersist => 'queue',
			ORM\Events::postUpdate => 'queue',
			ORM\Events::preRemove => 'queue',
			ORM\Events::postFlush => 'flush',
		];
	}

	/**
	 * @param Common\Persistence\Event\LifecycleEventArgs $args
	 * @internal
	 */
	public function queue(Common\Persistence\Event\LifecycleEventArgs $args)
	{
		$object = $args->getObject();

		if ($object instanceof Cacheable) {
			$this->invalidator->queue($object);
		}
	}

	/**
	 * @internal
	 */
	public function flush()
	{
		$this->invalidator->flush();
	}

}
