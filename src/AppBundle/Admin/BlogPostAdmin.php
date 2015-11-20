<?php
namespace AppBundle\Admin;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use AppBundle\Entity\BlogPost;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class BlogPostAdmin extends Admin
{
    
    public $supportsPreviewMode = true;
    
    //you can code here to talk form edit field
    protected function configureFormFields(FormMapper $formMapper)
    {
        
        // ... configure $formMapper
        $formMapper->add('title', 'text')->add('body', 'textarea');
        //using own modle
        //将对象塞入普通的select控件中
       /*$formMapper->add('category', 'entity', array(
            'class' => 'AppBundle\Entity\Category',
            'property' => 'name',
        ));*/
        //设置类似autocomplete方式，可设置成另一张表的某个字段，在用户输入时进行autocomplete操作
        $formMapper
            ->add('category', 'sonata_type_model_autocomplete', array(
                'property' => 'name',
                'to_string_callback' => function($entity, $property) {
                    return $entity->getName();
                },
            ));
        //$formMapper ->with('Content')->add('title', 'text')->add('body', 'textarea')->end();
    }
    
    // code here to talk list anyone filed you allow  show
    protected function configureListFields(ListMapper $listMapper)
    {
        // ... configure $listMapper
        $listMapper->addIdentifier('title')->add('category.name')->add('draft');
        $listMapper->addIdentifier('body');
        //$listMapper->addIdentifier('draft');
        //$listMapper->addIdentifier('category_id');
    }
    
    //you can code here to define your search field
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title')->add("body");
        $datagridMapper
            ->add('category', null, array(), 'entity', array(
                'class'    => 'AppBundle\Entity\Category',
                'property' => 'name',
            ));
    }
    
    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper->add("title")
                   ->add("body")
                   ->add("category_id")->add("draft");
           
    }

    
    public function toString($object)
    {
        return $object instanceof BlogPost ? $object->getTitle() : 'Blog Post'; // shown in the breadcrumb on the create view
    }
    
    //code here to define your BatchAction
    public function getBatchActions(){
       $actions = parent::getBatchActions();
         if (
            $this->hasRoute('edit') && $this->isGranted('EDIT') &&
            $this->hasRoute('delete') && $this->isGranted('DELETE')
          ) {
                $actions['merge'] = array(
                    'label' => 'action_merge',
                    'ask_confirmation' => false
                );
          }
         return $actions;
    }
    
    public function getExportFormats()
    {
        return array(
            'json', 'xml', 'csv', 'xls',"pdf"
        );
    }
    
}

