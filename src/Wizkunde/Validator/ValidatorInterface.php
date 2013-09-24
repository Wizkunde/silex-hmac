<?php
namespace Wizkunde\Validator;

interface ValidatorInterface
{
    /**
     * Get validation constraints
     * @return mixed
     */
    public function getConstraints();
}