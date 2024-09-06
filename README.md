# php-form-validation-class
PHP Class that validates form values

# How to Use
Put form fields into an array and state which validation methods to apply.
```php
    $fields = [
        'username' => ['required', 'minlen' => 5, 'maxlen' => 15],
        'email' => ['required', 'email'],
        'password' => ['required', 'minlen' => 8],
        'confirm_password' => ['required', 'match' => 'password'],
        'age' => ['required', 'number'],
    ];
```

# Validation Methods

## `required`
The field is required and must not be empty.

## `minlen`
Sets the minimum acceptable length of the field.

## `maxlen`
Sets the maximum acceptable length of the field.

## `email`
Ensures the field value is an Email Address.

## `match`
Validates that this field matches the same value as the field set in the `match` value.

## `number`
Ensures the field value is a number.

# Instantiate the Class
Create a new object called $validator and use the $_POST array and previously declared $fields array to instantiate it.
Set the $errors variable with any errors that may be thrown when validating the form.
```php
$validator = new Validate($_POST, $fields);
$errors = $validator->validateForm();
```

# Show Errors
```php
if (empty($errors)) {
        echo "Form submitted successfully!";
    } else {
        foreach ($errors as $error) {
            echo "<p>$error</p>";
    }
}
```
