<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class NewsTypeAdmin extends Admin{
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper ->add('type', 'text');
        
    }
    
    // code here to talk list anyone filed you allow  show
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier("id");
        $listMapper->addIdentifier("type");
       
    }
    
    
    public function toString($object) {
        return $object instanceof \AppBundle\Entity\NewsType ? $object->getType():"新闻种类";
    }
    
}