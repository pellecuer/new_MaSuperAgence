<?php
namespace App\Listener;

use Doctrine\Common\EventSubscriber;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use App\Entity\Property;
use Doctrine\Common\Persistence\Event\PreUpdateEventArgs;

class ImageCacheSubscriber Implements EventSubscriber {
    
    
    /**
     * @var CacheManager
     */
    private $cacheManager;

    /**
     * @var UploaderHelper
     */
    private $uploaderHelper;  

    
    /**
     * @var UploaderHelper
     */
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

    public function preRemove (LifecycleEventArgs $args){        
        $entity = $args->getEntity();
        if (!$entity instanceof Property) {
            return;
        }
        $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
      

    }

    public function preUpdate(PreUpdateEventArgs $args) {
        $entity = $args->getEntity();
        if (!$entity instanceof Property) {
            return;
        }
        if($entity->getImageFile() instanceof UploadedFile){
            $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
        };        
    }
}


