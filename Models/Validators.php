<?php

namespace Bootstrap\Models;

trait Validators {

    /* @var $this BootstrapModel */

    /**
     * Validates input variables by a set of rules.
     * If variables are not explicitly passed it will default to the
     * currently submitted ones.
     *
     * Validation depends on the rules and each of them passing.
     * The validation rules are passed as key value pairs where the key
     * is the name of the variable in the input and the value is the ruleset.
     *
     * The ruleset is a string that can define multiple validation rules.
     * Each rule in the string is separated using '|' as a delimeter.
     * Additional parameters can be passed to the rule using ':'
     *
     * Each rule depends on the trait having defined a method with the
     * appropriate name.
     *
     * Example ruleset:
     * aray(
     *     'name' => 'empty|length:3',
     *     'age' => 'empty|greater_than:18',
     *     'email' => 'empty|email'
     * )
     *
     * @param array $rules
     * @param array $variables
     * @return bool
     */
    public function validateByRules(array $rules, $variables = array()): bool
    {
        if (empty($variables)) {
            $variables = $this->getAllSubmittedVariablesByName();
        }

        foreach ($rules as $variable => $ruleset) {

            $value = $variables[$variable];

            // Split ruleset in subrules and loop through the results
            foreach (explode('|', $ruleset) as $rule) {

                $rule = explode(':', $rule);
                $methodName = 'validate' . $this->toPascalCase($rule[0], true);

                if (count($rule) === 1) {
                    // If there are no parameters after the ':' call the method with the current value
                    $isValid = $this->{$methodName}($value);

                } else {
                    // Else call it with the parameter added for the current rule
                    $isValid = $this->{$methodName}($value, $rule[1]);

                }

                if (!$isValid) {
                    return false;
                }

            }

        }

        return true;
    }

    /**
     * Validates whether the given value is not empty.
     *
     * @param $value
     * @return bool
     */
    public function validateEmpty($value)
    {
        return !empty($value);
    }

    public function validateLength($value, $length)
    {
        return strlen($value) > $length;
    }

    public function validateCount($value, $length)
    {
        return count($value) > $length;
    }

    public function validateGreaterThan($value, $number)
    {
        return $value > $number;
    }

    public function validateLessThan($value, $number)
    {
        return $value < $number;
    }

    /**
     * Email validation
     *
     * @param $email
     * @return bool
     */
    public function validateEmail($email){

        if ( empty($email) ) {
            return false;
        }

        $validator = new \CEmailValidator;
        $validator->checkMX = true;

        $email = rtrim( $email );

        // Email must contain only lowercase letters
        if ( preg_match('/[A-Z]/', $email) ) {
            return false;
        }

        if ($validator->validateValue($email)) {
            return true;
        }

        return false;
    }

    /**
     * Website validation
     *
     * @param $url
     * @return bool
     */
    public function validateWebsite($url){
        if(strlen($url) < 4){
            return false;
        }

        if(!stristr($this->getSavedVariable('website'),'http')){
            $url = 'http://'.$url;
        }

        $url = parse_url($url);
        if (!isset($url["host"])) return false;
        return !(gethostbyname($url["host"]) == $url["host"]);
    }

    /**
     * Password validation
     *
     * @param $password
     * @param bool $strict
     * @return bool
     */
    public function validatePassword($password,$strict=false){
        if($strict){
            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number    = preg_match('@[0-9]@', $password);

            if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
                return false;
            }
        }

        if(strlen($password) > 3){
            return true;
        }

        return false;

    }
}