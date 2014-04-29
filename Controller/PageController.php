<?php

/**
 * @author Luis Sanchez <luis.sanchez.saldana@gmail.com>
 */

namespace Stiwl\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Ivory\GoogleMap\MapTypeId;
use Ivory\GoogleMap\Overlays\Animation;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * PageController
 * 
 * This class contains the page controller
 */
class PageController extends Controller {

    /**
     * Index of the page, basically if page news is enabled go to news, else go to login
     * @return RedirectResponse
     */
    public function indexAction() {
        $config = $this->container->getParameter('stiwl_page.config');
        //print_r($config);
        if ($config['pages']['news']['enabled']) {
            return $this->redirect($this->generateUrl('stiwl_pageB_news'));
        } else {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
    }

    /**
     * The login page without FOSUserBundle
     * @return Response
     */
    public function loginAction() {
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the error of the login if exist an error
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        return $this->render('StiwlPageBundle:Page:login.html.twig', array(
                    'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                    'error' => $error)
        );
    }

    /**
     * The content of page
     * @param integer $menuId
     * @param string $slug
     * @return Response
     * @throws NotFoundHttpException
     */
    public function pageAction($menuId, $slug) {
        $em = $this->getDoctrine()->getManager();
        $language = $this->getRequest()->getLocale();
        $page = $em->getRepository('StiwlPageBundle:Page')->findOne_menuId_language($menuId, $language);
        if (!$page) {
            throw $this->createNotFoundException('Page not found');
        }
        return $this->render('StiwlPageBundle:Page:page.html.twig', array('page' => $page));
    }

    /**
     * Contact page
     * @return Response
     */
    public function contactUsAction() {
        $config = $this->get('service_container')->getParameter('stiwl_page.config');
        $latitude = $config['enterprise']['google_map']['latitude'];
        $longitude = $config['enterprise']['google_map']['longitude'];
        $width = $config['enterprise']['google_map']['width'];
        $height = $config['enterprise']['google_map']['height'];
        $map = $this->get('ivory_google_map.map');
        $map->setCenter($latitude, $longitude, true);
        $map->setMapOption('zoom', 16);
        $map->setMapOption('mapTypeId', MapTypeId::ROADMAP);

        $map->setMapOptions(array(
            'disableDefaultUI' => true,
            'disableDoubleClickZoom' => true
        ));

        $map->setStylesheetOptions(array(
            'width' => $width,
            'height' => $height
        ));

        $map->setLanguage('es');

        $marker = $this->get('ivory_google_map.marker');

        // Configure your marker options
        $marker->setPrefixJavascriptVariable('marker_');
        $marker->setPosition($latitude, $longitude, true);
        $marker->setAnimation(Animation::DROP);

        $marker->setOption('clickable', false);
        $marker->setOption('flat', true);
        $marker->setOptions(array(
            'clickable' => false,
            'flat' => true
        ));

        $map->addMarker($marker);

        $form = $this->createForm(new \Stiwl\PageBundle\Form\Type\ContactType());
        $request = $this->getRequest();
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $message = \Swift_Message::newInstance()
                        ->setSubject($form->get('subject')->getData())
                        ->setFrom($form->get('email')->getData())
                        ->setTo($config['enterprise']['email'])
                        ->setBody($form->get('message')->getData(), 'text/plain')
                ;
                $this->get('mailer')->send($message);
            }
        }


        return $this->render('StiwlPageBundle:Page:contactUs.html.twig', array(
                    'form' => $form->createView(),
                    'map' => $map
        ));
    }

    /**
     * Get all product's categories
     * @return Response
     */
    public function categoriesAction() {
        $em = $this->getDoctrine()->getManager();
        $language = $this->getRequest()->getLocale();
        $categories = $em->getRepository('StiwlPageBundle:Category')->findAll_language($language);
        return $this->render('StiwlPageBundle:Page:categories.html.twig', array(
                    'categories' => $categories
        ));
    }

    /**
     * Get one product depending id and optional slug
     * @param integer $productId
     * @param string $productSlug
     * @return Response
     * @throws NotFoundHttpException
     */
    public function productAction($productId, $productSlug = null) {
        $em = $this->getDoctrine()->getManager();
        $language = $this->getRequest()->getLocale();
        $product = $em->getRepository('StiwlPageBundle:Product')->findOne_id_language($productId, $language);
        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }
        return $this->render('StiwlPageBundle:Page:product.html.twig', array(
                    'product' => $product
        ));
    }

    /**
     * Show products
     * @return Response
     */
    public function productsAction() {
        $em = $this->getDoctrine()->getManager();
        $language = $this->getRequest()->getLocale();
        $products = $em->getRepository('StiwlPageBundle:Product')->findAllNews_limit_language(10, $language);
        return $this->render('StiwlPageBundle:Page:products.html.twig', array(
                    'products' => $products
        ));
    }

    /**
     * Get products depending category id
     * @param integer $categoryId
     * @return Response
     */
    public function productsCategoryAction($categoryId = null) {
        $em = $this->getDoctrine()->getManager();
        $language = $this->getRequest()->getLocale();
        $products = $em->getRepository('StiwlPageBundle:Product')->findAll_categoryId_language($categoryId, $language);
        $paginator = $this->get('knp_paginator');
        $productsPagination = $paginator->paginate(
                $products, $this->getRequest()->query->get('page', 1)/* page number */, 10/* limit per page */
        );
        return $this->render('StiwlPageBundle:Page:productsCategory.html.twig', array(
                    'productsPagination' => $productsPagination
        ));
    }

    /**
     * Set the locale when change the page's language 
     * @param string $_locale
     * @param string $route
     * @param string $routeParams
     * @return RedirectResponse
     */
    public function setLocaleAction($_locale, $route, $routeParams = null) {
        $parameters = array();
        if ($routeParams) {
            $parameters = $this->get('stiwl_page.twig_extension')->explodeRouteParams($routeParams);
            $parameters = array_merge($parameters, array('_locale' => $_locale));
        } else {
            $requestQuery = $this->getRequest()->query;
            foreach ($requestQuery as $key => $value) {
                if ($key != 'ddlbLanguage') {
                    $parameters[$key] = $value;
                }
            }
            $arrLocale = array('_locale' => $requestQuery->get('ddlbLanguage'));
            $parameters = array_merge($parameters, $arrLocale);
        }
        return $this->redirect($this->generateUrl($route, $parameters));
    }

    /**
     * Get all news
     * @return Response
     */
    public function newsAction() {
        $em = $this->getDoctrine()->getManager();
        $language = $this->getRequest()->getLocale();
        $news = $em->getRepository('StiwlPageBundle:News')->findAll_language($language);
        return $this->render('StiwlPageBundle:Page:news.html.twig', array(
                    'news' => $news
        ));
    }

    /**
     * Get the content of one news depending news id and optional slug
     * @param integer $newsId
     * @param string $newsSlug
     * @return Response
     * @throws NotFoundHttpException
     */
    public function newsContentAction($newsId, $newsSlug = null) {
        $em = $this->getDoctrine()->getManager();
        $language = $this->getRequest()->getLocale();
        $news = $em->getRepository('StiwlPageBundle:News')->findOne_id_language($newsId, $language);
        if (!$news) {
            throw $this->createNotFoundException('News not found');
        }
        return $this->render('StiwlPageBundle:Page:newsContent.html.twig', array(
                    'news' => $news
        ));
    }

    /**
     * Get the historial of the news
     * @return Response
     */
    public function newsSidebarAction() {
        $em = $this->getDoctrine()->getManager();
        $language = $this->getRequest()->getLocale();
        $news = array();
        $news = $em->getRepository('StiwlPageBundle:News')->findAll_language($language);
        return $this->render('StiwlPageBundle:Page:newsSidebar.html.twig', array(
                    'news' => $news
        ));
    }

}
