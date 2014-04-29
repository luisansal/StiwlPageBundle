<?php

/**
 * @author Luis Sanchez <luis.sanchez.saldana@gmail.com>
 */

namespace Stiwl\PageBundle\Controller\Admin;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * MenuAdminController
 * 
 * This class contains the menu's admin controller
 */
class MenuAdminController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function showAction($id = null) {
        $id = $this->get('request')->get($this->admin->getIdParameter());

        $object = $this->admin->getObject($id);
        $em = $this->getDoctrine()->getManager();

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        if (false === $this->admin->isGranted('VIEW', $object)) {
            throw new AccessDeniedException();
        }
        $menu = $em->getRepository('StiwlPageBundle:Menu')->findOne_id_language_default_parent($object->getId(), $this->getRequest()->getLocale());
        if ($menu->getParent()) {
            $menu = $em->getRepository('StiwlPageBundle:Menu')->findOne_id_language_default_parent($object->getId(), $this->getRequest()->getLocale(), false, true);
        }

        $this->admin->setSubject($object);

        return $this->render($this->admin->getTemplate('show'), array(
                    'action' => 'show',
                    'object' => $menu,
                    'elements' => $this->admin->getShow(),
        ));
    }

}
