<?php
/**
 * Created by PhpStorm.
 * User: sigridnarep
 * Date: 28/4/18
 * Time: 3:39 PM
 */

class Contact
{
    public $id;
    public $firstName;
    public $lastName;
    public $numbers = [];

    function addNumber($number) {
        if (isset($number)) {
            $this->numbers[] = $number;
        }
    }
}