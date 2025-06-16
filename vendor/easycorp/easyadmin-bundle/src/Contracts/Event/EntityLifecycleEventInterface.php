<?php

namespace EasyCorp\Bundle\EasyAdminBundle\Contracts\Event;

/**
 * @author: Benjamin Leibinger <mail@leibinger.io>
 *
 * @template TEntity of object
 */
interface EntityLifecycleEventInterface
{
    /**
     * @return TEntity
     */
    public function getEntityInstance();
}
