<?php

namespace App\Controller\CaseStudy;

use Symfony\Component\Routing\Annotation\Route;

class ProbabilytyTheoryController extends AbstractCaseStudyController
{
    protected $directory = 'probability-theory';
    protected $indexFile = 'README.md';
    protected $template = 'case-study/index.html.twig';
    protected $indexRoute = 'probability-theory-index';
    protected $baseTitle = 'Probability Theory';

    /**
     * @Route(name="probability-theory-index", path="/probability-theory")
     */
    public function probabilityTheoryIndex()
    {
        return $this->indexAction();
    }

    /**
     * @Route(name="probability-theory-article", path="/probability-theory/{file}", requirements={"file"=".*(?<!jpg)$"})
     */
    public function probabilityTheoryArticle($file)
    {
        return $this->articleAction($file);
    }
}
