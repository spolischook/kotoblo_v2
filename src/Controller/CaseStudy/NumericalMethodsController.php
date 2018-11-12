<?php

namespace App\Controller\CaseStudy;

use Symfony\Component\Routing\Annotation\Route;

class NumericalMethodsController extends AbstractCaseStudyController
{
    protected $directory = 'numerical-methods';
    protected $indexFile = 'README.md';
    protected $template = 'case-study/index.html.twig';
    protected $indexRoute = 'numerical-methods-index';
    protected $baseTitle = 'Numerical Methods';

    /**
     * @Route(name="numerical-methods-index", path="/numerical-methods")
     */
    public function probabilityTheoryIndex()
    {
        return $this->indexAction();
    }

    /**
     * @Route(name="numerical-methods-article", path="/numerical-methods/{file}", requirements={"file"=".*(?<!jpg)$"})
     */
    public function probabilityTheoryArticle($file)
    {
        return $this->articleAction($file);
    }
}
