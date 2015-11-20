<?php

namespace AppBundle\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use RuntimeException;
use AppBundle\Entity\BlogPost;
use Sonata\AdminBundle\Controller\CRUDController as BaseCrudController;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CRUDController extends BaseCrudController {

    public function exportAction(Request $request) {
        if (false === $this->admin->isGranted('EXPORT')) {
            throw new AccessDeniedException();
        }

        $format = $request->get('format');

        $allowedExportFormats = (array) $this->admin->getExportFormats();
        //check format is in allow format array
        if (!in_array($format, $allowedExportFormats)) {
            throw new RuntimeException(
            sprintf(
                    'Export in format `%s` is not allowed for class: `%s`. Allowed formats are: `%s`', $format, $this->admin->getClass(), implode(', ', $allowedExportFormats)
            )
            );
        }

        $filename = sprintf(
                'export_%s_%s.%s', strtolower(substr($this->admin->getClass(), strripos($this->admin->getClass(), '\\') + 1)), date('Y_m_d_H_i_s', strtotime('now')), $format
        );
        return $this->get('my_export')->getResponse(
                        $format, $filename, $this->admin->getDataSourceIterator()
        );
    }

    public function batchActionMergeIsRelevant(array $selectedIds, $allEntitiesSelected, Request $request = null) {

        $parameterBag = $this->get('request')->request;

        // check that a target has been chosen
        if (!$parameterBag->has('targetId')) {
            return 'flash_batch_merge_no_target';
        }

        $targetId = $parameterBag->get('targetId');
        // if all entities are selected, a merge can be done
        if ($allEntitiesSelected) {
            return true;
        }

        // filter out the target from the selected models
        $selectedIds = array_filter($selectedIds, function($selectedId) use($targetId) {
            return $selectedId !== $targetId;
        }
        );
        // if at least one but not the target model is selected, a merge can be done.
        return count($selectedIds) > 0;
    }

    /**
     * @param ProxyQueryInterface $selectedModelQuery
     * @param Request             $request
     *
     * @return RedirectResponse
     */
    public function batchActionMerge(ProxyQueryInterface $selectedModelQuery) {
        if ($this->admin->isGranted('EDIT') === false || $this->admin->isGranted('DELETE') === false) {
            throw new AccessDeniedException();
        }

        $request = $this->get('request');
        $modelManager = $this->admin->getModelManager();
        $target = $modelManager->find($this->admin->getClass(), $request->get('targetId'));

        if ($target === null) {
            $this->addFlash('sonata_flash_info', 'flash_batch_merge_no_target');

            return new RedirectResponse($this->admin->generateUrl('list', array('filter' => $this->admin->getFilterParameters())));
        }

        $selectedModels = $selectedModelQuery->execute();

        // do the merge work here

        try {
            foreach ($selectedModels as $selectedModel) {
                $modelManager->delete($selectedModel);
            }

            $modelManager->update($selectedModel);
        } catch (\Exception $e) {
            $this->addFlash('sonata_flash_error', 'flash_batch_merge_error');

            return new RedirectResponse($this->admin->generateUrl('list', array('filter' => $this->admin->getFilterParameters())));
        }

        $this->addFlash('sonata_flash_success', 'flash_batch_merge_success');

        return new RedirectResponse($this->admin->generateUrl('list', array('filter' => $this->admin->getFilterParameters())));
    }

}
