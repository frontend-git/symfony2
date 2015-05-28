<?php

namespace Dusk\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends Controller {

    public function indexAction() {
        return $this->render('DuskUserBundle:Blog:index.html.twig');
    }

}
