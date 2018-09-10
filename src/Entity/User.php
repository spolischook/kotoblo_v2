<?php

namespace App\Entity;

use FOS\UserBundle\Model\User as FOSUBUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends FOSUBUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="github_id", type="string", length=255, nullable=true)
     */
    private $githubId;

    /**
     * @ORM\Column(name="avatar_url", type="text", nullable=true)
     */
    private $avatarUrl;

    private $githubAccessToken;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @param string $githubId
     * @return User
     */
    public function setGithubId($githubId)
    {
        $this->githubId = $githubId;

        return $this;
    }

    /**
     * @return string
     */
    public function getGithubId()
    {
        return $this->githubId;
    }

    /**
     * @param string $githubAccessToken
     * @return User
     */
    public function setGithubAccessToken($githubAccessToken)
    {
        $this->githubAccessToken = $githubAccessToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getGithubAccessToken()
    {
        return $this->githubAccessToken;
    }

    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }

    public function setAvatarUrl(string $avatarUrl): self
    {
        $this->avatarUrl = $avatarUrl;

        return $this;
    }
}
