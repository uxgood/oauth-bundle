<?php

namespace UxGood\Bundle\OAuthBundle\Security\Core\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class OAuthToken extends AbstractToken
{
    /**
     * {@inheritdoc}
     */
    public function __construct($user, array $roles = array())
    {
        parent::__construct($roles);
        parent::setAuthenticated(count($roles) > 0);
        $this->setUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function setAuthenticated($isAuthenticated)
    {
        if ($isAuthenticated) {
            throw new \LogicException('Cannot set this token to trusted after instantiation.');
        }

        parent::setAuthenticated(false);
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize(array(
            parent::serialize(),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        // add a few extra elements in the array to ensure that we have enough keys when un-serializing
        // older data which does not include all properties.
        $data = array_merge($data, array_fill(0, 4, null));

        list(
            $parent) = $data;

        parent::unserialize($parent);
    }
}
