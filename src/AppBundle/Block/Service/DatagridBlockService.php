<?php

namespace AppBundle\Block\Service;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\AdminBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DatagridBlockService extends BaseBlockService {

    protected $em;
    protected $type;
    protected $templating;
    protected $admin;
    public function __construct($type, $templating, $em ) {
        $this->type = $type;
        $this->templating = $templating;
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'Data Reader';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'target' => 'please enter your target',
            'template' => '',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block) {
        $errorElement
                ->with('settings[target]')
                ->assertNotNull(array())
                ->assertNotBlank()
                ->end();
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null) {

        //传入的参数，此处是指target
        $settings = $blockContext->getSettings();

        if ($settings["target"]) {
            //do your something
            $tablename = "AppBundle:" . $settings["target"];
            $entityName = strtolower($settings['target']);
            //设置limit
            $data = $this->em->getRepository($tablename)->findBy(array(),array(),4,0);
            
        }
        return $this->renderResponse('AppBundle::tablelist.html.twig', array(
                    'block' => $blockContext->getBlock(),
                    'settings' => $settings,
                    'data' => $data,
                        ), $response);
    }

}
