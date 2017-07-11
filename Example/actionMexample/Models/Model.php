<?php


namespace packages\actionMexample\Models;
use Bootstrap\Models\BootstrapModel;
use function is_numeric;
use function str_replace;
use function stristr;
use function strtolower;
use function ucwords;

class Model extends BootstrapModel {

    public $validation_errors;

    private $password;
    private $phone;
    private $email;
    private $firstname;
    private $lastname;

    /* gets a list of configuration fields, these are used by the view */
    public function getFieldList(){
        $params = $this->getAllConfigParams();
        $output = array();

        foreach($params as $key=>$item){
            if(stristr($key, 'mreg') AND $item){
                $output[] = $key;
            }
        }

        return $output;
    }

    /* active selected country for the phone number field */
    public function getCountry(){

        if($this->getSubmittedVariableByName('country_selected')){
            $country = $this->getSubmittedVariableByName('country_selected');
            $this->sessionSet('selected_country', $country);
        } elseif($this->sessionGet('country')){
            $country = $this->sessionGet('selected_country');
        } else {
            $country = '+44';
        }

        return $country;
    }

    /* save to variables */
    public function savePage1(){
        $vars['password'] = sha1(strtolower(trim($this->password)));
        $vars['email'] = $this->email;
        $vars['phone'] = $this->phone;
        $vars['firstname'] = $this->firstname;
        $vars['lastname'] = $this->lastname;
        $vars['real_name'] = $this->firstname .' ' .$this->lastname;
        $this->saveNamedVariables($vars);
    }

    /* will save all validated variables and add rest to error array */
    public function validatePage1(){
        $vars = $this->getAllSubmittedVariablesByName();

        foreach($vars as $key=>$var){

            switch ($key){
                case 'firstname':
                    $this->firstname = strtolower($var);
                    $this->firstname = ucwords($this->firstname);
                    if(strlen($var) < 2){
                        $this->validation_errors[$key] = '{#please_input_a_valid_first_name#}';
                    }
                    break;

                case 'lastname':
                    $this->lastname = strtolower($var);
                    $this->lastname = ucwords($this->lastname);
                    if(strlen($var) < 2) {
                        $this->validation_errors[$key] = '{#please_input_a_valid_last_name#}';
                    }
                    break;

                case 'email':
                    $this->email = strtolower($var);
                    
                    if(!$this->validateEmail($this->email)){
                        $this->validation_errors[$key] = '{#please_input_a_valid_email#}';
                    }
                    break;

                case 'password':
                    $this->password = $var;

                    if(!$this->validatePassword($var)){
                        $this->validation_errors[$key] = '{#password_needs_to_be_at_least_four_characters#}';
                    }

                    break;

                case 'password_again':
                    if($this->getSubmittedVariableByName('password') != $var){
                        $this->validation_errors[$key] = '{#passwords_dont_match#}';
                    }
                    break;

                case 'phone':
                    $this->phone = str_replace(' ', '', $var);
                    if(!is_numeric($this->phone)){
                        $this->validation_errors[$key] = '{#please_only_input_numbers#}';
                    }

                    if(strlen($this->phone) < 5){
                        $this->validation_errors[$key] = '{#please_enter_a_valid_phone_number#}';
                    }

                    break;

            }
        }
    }

    /* adds required variables and closes the login */
    public function closeLogin($dologin=true){
        if ($this->getConfigParam('require_login') == 1) {
            return true;
        }

        $this->saveVariable('reg_phase','complete');

        $branch = $this->getConfigParam('login_branch');

        if($dologin){
            $this->saveVariable('logged_in',1);
        }

        if(!$branch){
            return false;
        }

        \AeplayBranch::closeBranch($branch,$this->playid);
        return true;
    }


}