<?php

namespace App\Controller\CaseStudy;

use App\Parsedown;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractCaseStudyController extends AbstractController
{
    protected $caseStadyDir;
    protected $baseUrl;
    protected $parsedown;

    protected $directory = null;
    protected $indexFile = null;
    protected $template = null;
    protected $indexRoute = null;
    protected $baseTitle = null;


    public function __construct($projectDir, Parsedown $parsedown, RouterInterface $router)
    {
        $this->caseStadyDir = $projectDir.'/public/'.$this->directory.'/';
        $this->baseUrl = $router->generate($this->indexRoute, [], UrlGeneratorInterface::ABSOLUTE_PATH);
        $this->parsedown = $parsedown;
    }

    public function indexAction()
    {
        return $this->render($this->template, [
            'title' => $this->baseTitle,
            'body' => $this->parsedown->textFile(
                $this->caseStadyDir.$this->indexFile,
                $this->caseStadyDir,
                $this->baseUrl
            ),
        ]);
    }

    public function articleAction($file)
    {
        return $this->render($this->template, [
            'title' => $this->baseTitle,
            'base_url' => $this->baseUrl,
            'body' => $this->parsedown->textFile(
                $this->caseStadyDir.$file.'.md',
                $this->caseStadyDir,
                $this->baseUrl
            ),
        ]);
    }
}
