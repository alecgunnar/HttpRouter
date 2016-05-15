# Model Authentication

A simple library to provide only the most basic authentication capabilities to your application.

## Usage

Let us examine a sample scenario where we have a model called `User`, and we need to check a password against an object of this model.

First we'll list the classes we'll be using, and also define a password to test with.
```php
<?php

use AlecGunnar\ModelAuth\AuthenticatableInterface;
use AlecGunnar\ModelAuth\HashScheme\BcryptHashScheme;
use AlecGunnar\ModelAuth\Authenticator;

$password = 'superSecret123';
```

Here is the sample `User` model.
```php
// ...

class User implements AuthenticatableInterface {
    private $hash;    

    public function setPasswordHash ($passwdHash) {
        $this->hash = $passwdHash;
    }

    public function getPasswordHash () {
        return $hash;
    }
}
```

Next we'll create an object of the hash scheme, specifically the BCrypt hash scheme. With this, we'll generate a hash of the password we defined earlier
```php
// ...

$hashScheme = new BcryptHashScheme();
$hashedPassword = $hashScheme->generateHash($password);
```

We now need to create a user to authenticate, to which we will also assign the password hash we previously generated.
```php
// ...

$user = new User();
$user->setPasswordHash($hashedPassword);
```

Now we can actually authenticate the user we just created using the password we defined at the beginning. This is a trivial example, and it should be obvious that this result will be `It is a valid password!` being echoed.
```php
// ...

$auth = new Authenticator($hashScheme);

if ($auth->authenticate($user, $password)) {
    echo 'It is a valid password!';
} else {
    echo 'Not a valid password...';
}
```
