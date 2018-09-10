<?php

namespace App\Repository;

use App\Entity\Thread;
use FOS\CommentBundle\Model\CommentManagerInterface;
use FOS\CommentBundle\Model\ThreadManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class FosCommentsManager
{
    private $threadManager;
    private $commentManager;

    public function __construct(ThreadManagerInterface $threadManager, CommentManagerInterface $commentManager)
    {
        $this->threadManager = $threadManager;
        $this->commentManager = $commentManager;
    }
    
    public function getThread($id, Request $request)
    {
        $thread = $this->threadManager->findThreadById($id);
        if (null === $thread) {
            $thread = $this->threadManager->createThread();
            $thread->setId($id);
            $thread->setPermalink($request->getUri());

            // Add the thread
            $this->threadManager->saveThread($thread);
        }

        return $thread;
    }

    public function getComments(Thread $thread)
    {
        return $this->commentManager->findCommentTreeByThread($thread);
    }
}