<?php

namespace UxGood\Bundle\OAuthBundle\Security\Core\Authentication\Provider;

use UxGood\Bundle\OAuthBundle\Security\Core\Authentication\Token\OAuthToken;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationServiceException;

class OAuthProvider implements AuthenticationProviderInterface
{
    /**
     * @var UserCheckerInterface
     */
    private $userChecker;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @param UserCheckerInterface            $userChecker      User checker
     * @param TokenStorageInterface           $tokenStorage
     */
    public function __construct(UserCheckerInterface $userChecker, TokenStorageInterface $tokenStorage)
    {
        $this->userChecker = $userChecker;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(TokenInterface $token)
    {
        return
            $token instanceof OAuthToken
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function authenticate(TokenInterface $token)
    {
        if (!$this->supports($token)) {
            return;
        }

        // fix connect to external social very time
        if ($token->isAuthenticated()) {
            return $token;
        }

        /* @var OAuthToken $token */

        return $token;
    }

}
