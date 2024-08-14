<?php
namespace App\Providers;

class Validator {
    private $errors = array();
    private $key;
    private $value;
    private $name;

    public function field($key, $value, $name = null){
        $this->key = $key;
        $this->value = $value;
        if($name == null){
            $this->name = ucfirst($key);
        }else{
            $this->name = ucfirst($name);
        }
        return $this;
    }

    public function required(){
        if (empty($this->value)){
            $this->errors[$this->key] = "$this->name is required";
        }
        return $this;
    }

    public function max($length){
        if(strlen($this->value) > $length){
            $this->errors[$this->key] = "$this->name must be less than $length characters";
        }
        return $this;
    }

    public function min($length){
        if(strlen($this->value) < $length){
            $this->errors[$this->key] = "$this->name must be more than $length characters";
        }
        return $this;
    }

    public function email(){
        if(!empty($this->value) && !filter_var($this->value, FILTER_VALIDATE_EMAIL)){
            $this->errors[$this->key] = "Invalid $this->name format";
        }
        return $this;
    }

    public function date($format = 'Y-m-d') {
        if(!empty($this->value)){
            // Create a DateTime object from the date string
            $d = \DateTime::createFromFormat($format, $this->value);
            // Check if the date is valid and matches the format
            if(!($d && $d->format($format) === $this->value)) {
                $this->errors[$this->key] = "Invalid $this->name format, must be : " . $format . " ," . $this->value . " is given.";
            }
        }
        return $this;
    }

    /**
     * Validate time against format H:i:s
     */
    public function time() {
        if (!empty($this->value)) {
            // Define the regular expression for validating HH:mm format
            $pattern = '/^([01]\d|2[0-3]):([0-5]\d)$/';

            // Remove seconds by extracting only hours and minutes
            $value = substr($this->value, 0, 5); // Extract HH:mm
    
            // Check if the time matches the regular expression
            if (!preg_match($pattern, $value)) {
                $this->errors[$this->key] = "Invalid $this->name format, must be H:i. " . $this->value . " is given.";
            }
        }
        return $this;
    }
    

    public function isSuccess(){
        if(empty($this->errors)) return true;
    }

    public function getErrors(){
        if(!$this->isSuccess()) return $this->errors;
    }
}

?>