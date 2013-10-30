<?php

namespace Acl\Model;

use Zend\Permissions\Acl\Resource\ResourceInterface;

/**
 * Description of Resource
 *
 * @author mhrilwan < rilwanfit@gmail.com >
 */
class Resource implements ResourceInterface {

    const RESOURCE_SEPARATOR = '::';
    
    protected $_id;
    protected $_controller;
    protected $_action;
    
    /**
     * Array of resource code parents
     * @var null|Resource[]
     */
    protected $_parents;
    
    /**
     * Number of level that current resource is downgrade.
     * Sample:
     * level 0 : resourceId is [controller]::[action]
     * level 1 : resourceId is [controller]
     * @var type 
     */
    protected $_downgradeLevels = 0;

    /**
     * Used by Resultset to pass each database row to the entity
     * @param type $data
     */
    public function exchangeArray($data) {
        $this->setId( (isset($data['id'])) ? $data['id'] : null );
        $this->setController( (isset($data['controller'])) ? $data['controller'] : null );
        $this->setAction( (isset($data['action'])) ? $data['action'] : null );
        
        if(isset($data['parents'])) {
            foreach ($parents as $item) {
                $resource = new Resource();
                $resource->exchangeArray($item);
                $this->_parents[] = $resource->getResourceCode();
            }
        } else {
            $this->_parents = null;
        }
    }
    
    /**
     * Returns the string identifier of the resourcee
     * @return string|null
     */
    public function getResourceId() {
        
        //null resource
        if (is_null($this->getController())) {
            return null;
        }
        
        //add controller to resourceId
        $resourceId = mb_strtolower($this->getController(), 'UTF-8');

        //Add action if exists and if not is downgraded.
        if($this->getDowngradeLevels() === 0 && $this->getAction()) {
            $resourceId .= self::RESOURCE_SEPARATOR . mb_strtolower( $this->getAction(), 'UTF-8');
        }
        return $resourceId;
    }
    /**
     * 
     * @return type
     */
    public function getController() {
        return $this->_controller;
    }
    public function setController( $controller ) {
        $this->_controller = $controller; 
    }
    public function getAction() {
        return $this->_action;
    }
    public function setAction($action) {
        $this->_action = $action;
    }
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }
    public function getParents() {
        return $this->_parents;
    }
    public function setParents($parents) {
        $this->_parents = $parents;
    }

    /**
     * 
     * @return int
     */
    public function getDowngradeLevels() {
        return $this->_downgradeLevels;
    }
    
    /**
     * Increase level of resourceId
     */
    public function downgrade() {
        $this->_downgradeLevels++;
    }
}

?>
