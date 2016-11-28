<?php

namespace MSBios\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Class SecurityController
 * @package MSBios\AdminBundle\Controller
 */
class SecurityController extends Controller
{
    /**
     * Login
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/login")
     */
    public function loginAction()
    {
        /** @var Request $request */
        $request = $this->getRequest();
        /** @var  $session */
        $session = $request->getSession();

        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            /** @var  $error */
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            /** @var  $error */
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render(
            '@Admin/Security/login.html.twig', [
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error' => $error
        ]);
    }

    /**
     * @Route()
     */
    public function loginCheckAction() {

    }
}
