<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseFOSUBProvider;
use Symfony\Component\Security\Core\User\UserInterface;

class FOSUBUserProvider extends BaseFOSUBProvider
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        // get property from provider configuration by provider name
        // , it will return `facebook_id` in that case (see service definition below)
        $property = $this->getProperty($response);
        $username = $response->getUsername(); // get the unique user identifier

        //we "disconnect" previously connected users
        $existingUser = $this->userManager->findUserBy(array($property => $username));
        if (null !== $existingUser) {
            // set current user id and token to null for disconnect
            // ...

            $this->userManager->updateUser($existingUser);
        }
        // we connect current user, set current user id and token
        // ...
        $this->userManager->updateUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $userEmail = $response->getEmail();
        $user = $this->userManager->findUserByEmail($userEmail);

        // if null just create new user and set it properties
        if (null === $user) {
            $username = $response->getRealName();
            $user = $this->userManager->createUser();
            $user->setEnabled(true);

            if ($username) {
                $user->setUsername($username);
            } else {
                $user->setUsername($userEmail);
            }
            $user->setEmail($userEmail);
            $user->setAvatarUrl($response->getProfilePicture());
            $user->setPlainPassword(uniqid('pass_', true)); // just a workaround

            $this->em->persist($user);
            $this->em->flush();

            return $user;
        }
        // else update access token of existing user
        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';
        $user->$setter($response->getAccessToken()); //update access token

        return $user;
    }

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }
}