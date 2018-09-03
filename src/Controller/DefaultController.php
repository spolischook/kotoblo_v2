<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Tag;
use App\Parsedown;
use App\Repository\ArticleRepository;
use App\Repository\ThreadRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route(name="homepage", path="/")
     */
    public function index(ArticleRepository $articleRepository, ThreadRepository $threadRepository)
    {
        return $this->render('default/index.html.twig', [
            'articles' => $articleRepository->findBy(['published' => true], ['createdAt' => 'DESC']),
            'thread_comments' => $threadRepository->getNumberComments(),
        ]);
    }

    /**
     * @Route(name="about_me", path="/about-me")
     */
    public function aboutMe()
    {
        return $this->render('default/about_me.html.twig');
    }

    /**
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route(name="article_view", path="/articles/{slug}", methods={"GET"})
     * @ParamConverter(class="App\Entity\Article", options={"mapping": {"slug": "slug"}})
     */
    public function articleView(Article $article)
    {
        return $this->render('default/articleView.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @param Tag $tag
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route(name="tag_view", path="/tags/{slug}", methods={"GET"})
     * @ParamConverter(class="App\Entity\Tag", options={"mapping": {"slug": "slug"}})
     */
    public function tagView(Tag $tag)
    {
        return $this->render('default/tagView.html.twig', ['tag' => $tag]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route(name="play", path="/play")
     */
    public function play()
    {
        return $this->render('play.html.twig');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route(name="editor-template", path="/editor")
     */
    public function editor(Request $request)
    {
        return $this->render('components/editor.html.twig', [
            'element' => $request->getContent(),
        ]);
    }

    /**
     * @return JsonResponse
     * @Route(name="render-md", path="/render-md", methods={"POST"})
     */
    public function renderMd(Request $request)
    {
        $parsedown = new Parsedown();
        return new JsonResponse(['data' => $parsedown->text($request->getContent())]);
    }
}
