<?php

namespace AppBundle\Admin;

use AppBundle\Entity\News;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class NewsAdmin extends Admin {

    //you can code here to talk form edit field
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper->with('标题')->add('news_title', 'text')->end();
        $formMapper->with('内容')->add('news_content', 'textarea')->end();
        $formMapper->add('NewsType', 'entity', array(
            'class' => 'AppBundle\Entity\NewsType',
            'property' => 'type',
        ));
    }

    // code here to talk list anyone filed you allow  show
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper->addIdentifier("news_title");
        $listMapper->addIdentifier("news_content");
        $listMapper->addIdentifier('news_type.type');
    }

    public function toString($object) {
        return $object instanceof News ? $object->getNewsTitle() : '新闻'; // shown in the breadcrumb on the create view
    }

}
