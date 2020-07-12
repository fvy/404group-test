<?php

namespace Fvy\Group404\Models;

class User
{
    /**
     * @var string $firstName User's First Name
     */
    private $firstName;

    /**
     * @var string $secondName User's Name
     */
    private $secondName;

    /**
     * @var string $email User's Email
     */
    private $email;

    public static function fromState(array $state): User
    {
        //TODO: validate state before accessing keys!

        return new self(
            $state['first_name'],
            $state['second_name'],
            $state['email']
        );
    }

    public function __construct(string $firstName, string $secondName, string $email)
    {
        //TODO: validate parameters before setting them!

        $this->firstName = $firstName;
        $this->secondName = $secondName;
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->firstName . ', ' . $this->secondName;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getSecondName()
    {
        return $this->secondName;
    }
}