<?php

namespace AppBundle\Block\Service;

use Sonata\BlockBundle\Event\BlockEvent;
use Sonata\BlockBundle\Model\Block;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Qychen {

    public function show(BlockEvent $event) {
        $block = new Block();
        $block->setId(uniqid());
        $block->setsettings($event->getSettings());
        $block->setType("qychen.datagrid");
        $event->addBlock($block);
    }

}
