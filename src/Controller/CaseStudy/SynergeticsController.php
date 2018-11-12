<?php

namespace App\Controller\CaseStudy;

use Symfony\Component\Routing\Annotation\Route;

class SynergeticsController extends AbstractCaseStudyController
{
    protected $directory = 'synergetics';
    protected $indexFile = 'README.md';
    protected $template = 'case-study/index.html.twig';
    protected $indexRoute = 'synergetics-index';
    protected $baseTitle = 'Synergetics';

    /**
     * @Route(name="synergetics-index", path="/synergetics")
     */
    public function probabilityTheoryIndex()
    {
        return $this->indexAction();
    }

    /**
     * @Route(name="synergetics-article", path="/synergetics/{file}", requirements={"file"=".*(?<!jpg)$"})
     */
    public function probabilityTheoryArticle($file)
    {
        return $this->articleAction($file);
    }
}
