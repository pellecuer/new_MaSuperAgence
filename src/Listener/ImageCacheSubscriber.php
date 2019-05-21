<?php
namespace App\Listener;

use Doctrine\Common\EventSubscriber;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Doctrine\ORM\Event\PreFlushEventArgs;

class ImageCacheSubscriber Implements EventSubscriber {

    public function __construct(CacheManager $cacheManager, UploaderHelper $uploaderHelper)
    {
        $this->cacheManager = $cacheManager;
        $this->uploaderHelper = $uploaderHelper;
    }
    
    
    public function getSubscribedEvents()
    {
        return [
            'preRemove',
            'preUpdate'
        ];        
    } 

    public function preRemove (PreFlushEventArgs $args){
    }

    public function preUpdate(PreUpdateEventArgs $args) {
        dump($args->getEntity());
        dump($args->getObject());
    }
}


