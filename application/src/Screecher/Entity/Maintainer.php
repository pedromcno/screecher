<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 29/06/15
 * Time: 14:27
 */

namespace Screecher\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Maintainer
 * @package Screecher\Entity
 */
class Maintainer
{
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('email', new Assert\Email(array(
            'message' => 'The email "{{ value }}" is not a valid email.',
            'checkMX' => true,
        )));
    }


    /**
     * Maintainer id.
     *
     * @var integer
     */
    protected $id;

    /**
     * Maintainer email.
     *
     * @var string
     */
    protected $email;


    /**
     * Api.
     *
     * @var \Screecher\Entity\Api
     */
    protected $api;

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return \Screecher\Entity\Api
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * @param \Screecher\Entity\Api $api
     * @return $this
     */
    public function setApi($api)
    {
        $this->api = $api;

        return $this;
    }
}