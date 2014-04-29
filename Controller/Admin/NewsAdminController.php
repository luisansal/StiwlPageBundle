<?php

/**
 * @author Luis Sanchez <luis.sanchez.saldana@gmail.com>
 */

namespace Stiwl\PageBundle\Controller\Admin;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * NewsAdminController
 * 
 * This class contains the news's admin controller
 */
class NewsAdminController extends Controller {

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
        $news = $em->getRepository('StiwlPageBundle:News')->findOne_id_language($object->getId(), $this->getRequest()->getLocale());

        $this->admin->setSubject($object);

        return $this->render($this->admin->getTemplate('show'), array(
                    'action' => 'show',
                    'object' => $news,
                    'elements' => $this->admin->getShow(),
        ));
    }

}
