<?php
class Validate {
    private $data;
    private $errors = [];
    private static $fields = [];

    public function __construct($post_data, $fields) {
        $this->data = $post_data;
        self::$fields = $fields;
    }

    public function validateForm() {
        foreach (self::$fields as $field => $rules) {
            $value = trim($this->data[$field]);
            foreach ($rules as $rule) {
                $method = "validate_" . $rule;
                if (method_exists($this, $method)) {
                    $this->$method($field, $value);
                } else {
                    throw new Exception("Validation rule {$rule} does not exist.");
                }
            }
        }
        return $this->errors;
    }

    private function validate_required($field, $value) {
        if (empty($value)) {
            $this->addError($field, ucfirst($field) . " is required.");
        }
    }

    private function validate_email($field, $value) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, ucfirst($field) . " must be a valid email address.");
        }
    }

    private function validate_minlen($field, $value, $param) {
        if (strlen($value) < $param) {
            $this->addError($field, ucfirst($field) . " must be at least {$param} characters long.");
        }
    }

    private function validate_maxlen($field, $value, $param) {
        if (strlen($value) > $param) {
            $this->addError($field, ucfirst($field) . " must be no more than {$param} characters long.");
        }
    }

    private function validate_match($field, $value, $param) {
        if ($value !== $this->data[$param]) {
            $this->addError($field, ucfirst($field) . " must match {$param}.");
        }
    }

    private function validate_number($field, $value) {
        if (!is_numeric($value)) {
            $this->addError($field, ucfirst($field) . " must be a number.");
        }
    }

    private function addError($field, $message) {
        $this->errors[$field] = $message;
    }

    public function getErrors() {
        return $this->errors;
    }
}
?>
