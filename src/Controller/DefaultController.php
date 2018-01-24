<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route(name="homepage", path="/")
     */
    public function index()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route(name="about_me", path="/about-me")
     */
    public function aboutMe()
    {
        return $this->render('default/about_me.html.twig');
    }
}
