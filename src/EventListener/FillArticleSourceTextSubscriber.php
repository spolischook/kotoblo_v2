<?php

namespace App\EventListener;

use App\Entity\Article;
use App\Parsedown;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class FillArticleSourceTextSubscriber implements EventSubscriber
{
    /** @var Parsedown */
    private $parsedown;

    public function __construct(Parsedown $parsedown)
    {
        $this->parsedown = $parsedown;
    }

    public function getSubscribedEvents()
    {
        return [
            'prePersist',
            'preUpdate',
        ];
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->updateSourceText($args);
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->updateSourceText($args);
    }

    private function updateSourceText(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof Article) {
            $entity->setText($this->parsedown->text($entity->getTextSource()));
        }
    }
}
