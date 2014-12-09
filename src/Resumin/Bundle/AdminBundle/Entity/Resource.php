<?php

namespace Resumin\Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FSi\Bundle\ResourceRepositoryBundle\Model\ResourceFSiFile as BaseResource;

/**
 * @ORM\Entity(repositoryClass="FSi\Bundle\ResourceRepositoryBundle\Doctrine\ResourceRepository")
 * @ORM\Table(name="resource")
 */
class Resource extends BaseResource
{
}
