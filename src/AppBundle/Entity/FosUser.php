<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FosUser
 *
 * @ORM\Table(name="fos_user", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_957A647992FC23A8", columns={"username_canonical"}), @ORM\UniqueConstraint(name="UNIQ_957A6479A0D96FBF", columns={"email_canonical"}), @ORM\UniqueConstraint(name="UNIQ_957A6479C05FB297", columns={"confirmation_token"})})
 * @ORM\Entity
 */
class FosUser
{
    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=180, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="username_canonical", type="string", length=180, nullable=false)
     */
    private $usernameCanonical;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=180, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="email_canonical", type="string", length=180, nullable=false)
     */
    private $emailCanonical;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * @var string
     *
     * @ORM\Column(name="confirmation_token", type="string", length=180, nullable=true)
     */
    private $confirmationToken;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="password_requested_at", type="datetime", nullable=true)
     */
    private $passwordRequestedAt;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array", nullable=false)
     */
    private $roles;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    function getUsername() {
        return $this->username;
    }

    function getUsernameCanonical() {
        return $this->usernameCanonical;
    }

    function getEmail() {
        return $this->email;
    }

    function getEmailCanonical() {
        return $this->emailCanonical;
    }

    function getEnabled() {
        return $this->enabled;
    }

    function getSalt() {
        return $this->salt;
    }

    function getPassword() {
        return $this->password;
    }

    function getLastLogin(): \DateTime {
        return $this->lastLogin;
    }

    function getConfirmationToken() {
        return $this->confirmationToken;
    }

    function getPasswordRequestedAt(): \DateTime {
        return $this->passwordRequestedAt;
    }

    function getRoles() {
        return $this->roles;
    }

    function getId() {
        return $this->id;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setUsernameCanonical($usernameCanonical) {
        $this->usernameCanonical = $usernameCanonical;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setEmailCanonical($emailCanonical) {
        $this->emailCanonical = $emailCanonical;
    }

    function setEnabled($enabled) {
        $this->enabled = $enabled;
    }

    function setSalt($salt) {
        $this->salt = $salt;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setLastLogin(\DateTime $lastLogin) {
        $this->lastLogin = $lastLogin;
    }

    function setConfirmationToken($confirmationToken) {
        $this->confirmationToken = $confirmationToken;
    }

    function setPasswordRequestedAt(\DateTime $passwordRequestedAt) {
        $this->passwordRequestedAt = $passwordRequestedAt;
    }

    function setRoles($roles) {
        $this->roles = $roles;
    }

    function setId($id) {
        $this->id = $id;
    }


}
