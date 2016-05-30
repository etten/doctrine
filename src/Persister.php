<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine;

use Doctrine\ORM\EntityManager;

class Persister
{

	/** @var EntityManager */
	private $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	/**
	 * Flushes all changes to objects that have been queued up to now to the database.
	 * This effectively synchronizes the in-memory state of managed objects with the
	 * database.
	 *
	 * If an entity is explicitly passed to this method only this entity and
	 * the cascade-persist semantics + scheduled inserts/removals are synchronized.
	 * @param object|array|null $entity
	 * @return void
	 * @throws \Exception
	 */
	public function flush($entity = NULL)
	{
		$this->em->flush($entity);
	}

	/**
	 * Clears the EntityManager. All entities that are currently managed
	 * by this EntityManager become detached.
	 * @param string|null $entityName
	 * @return void
	 */
	public function clear($entityName = NULL)
	{
		$this->em->clear($entityName);
	}

	/**
	 * Tells the EntityManager to make an instance managed and persistent.
	 *
	 * The entity will be entered into the database at or before transaction
	 * commit or as a result of the flush operation.
	 *
	 * NOTE: The persist operation always considers entities that are not yet known to
	 * this EntityManager as NEW. Do not pass detached entities to the persist operation.
	 * @param object $entity
	 * @return void
	 */
	public function persist($entity)
	{
		$this->em->persist($entity);
	}

	/**
	 * Removes an entity instance.
	 *
	 * A removed entity will be removed from the database at or before transaction commit
	 * or as a result of the flush operation.
	 * @param object $entity
	 * @return void
	 */
	public function remove($entity)
	{
		$this->em->remove($entity);
	}

	/**
	 * Refreshes the persistent state of an entity from the database,
	 * overriding any local changes that have not yet been persisted.
	 * @param object $entity
	 * @return void
	 */
	public function refresh($entity)
	{
		$this->em->refresh($entity);
	}

	/**
	 * Detaches an entity from the EntityManager, causing a managed entity to
	 * become detached.  Unflushed changes made to the entity if any
	 * (including removal of the entity), will not be synchronized to the database.
	 * Entities which previously referenced the detached entity will continue to
	 * reference it.
	 * @param object $entity
	 * @return void
	 */
	public function detach($entity)
	{
		$this->em->detach($entity);
	}

	/**
	 * Merges the state of a detached entity into the persistence context
	 * of this EntityManager and returns the managed copy of the entity.
	 * The entity passed to merge will not become associated/managed with this EntityManager.
	 * @param object $entity
	 * @return object The managed copy of the entity.
	 */
	public function merge($entity)
	{
		return $this->em->merge($entity);
	}

	/**
	 * Determines whether an entity instance is managed in this EntityManager.
	 * @param object $entity
	 * @return bool
	 */
	public function contains($entity):bool
	{
		return $this->em->contains($entity);
	}

}
