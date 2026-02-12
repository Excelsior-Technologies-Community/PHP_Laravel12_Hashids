# PHP_Laravel12_Hashids

## Project Description

PHP_Laravel12_Hashids is a Laravel 12 based application that demonstrates how to implement the Hashids package to encode and decode numeric database IDs into unique hash strings.

The main purpose of this project is to hide raw auto-increment database IDs from URLs and replace them with secure-looking, non-sequential hash values.

## How Hashids Works

Hashids converts numeric values into unique hash strings using a salt and custom alphabet.

The generated hash is deterministic, meaning the same number will always generate the same hash when using the same salt and configuration.


```
Example:

100 → Bk1K6y420r  
Bk1K6y420r → 100

```
It is reversible but it is not encryption.

It is mainly used for ID obfuscation.



## Benefits of Using Hashids:

- Improves URL appearance

- Provides basic ID obfuscation

- Helps prevent ID enumeration attacks

- Creates a more professional API structure




## Project Objectives

- To understand ID obfuscation in Laravel

- To implement Hashids in Laravel 12

- To configure custom salt, length, and alphabet

- To handle encode and decode operations

- To structure a Laravel project professionally


## Technologies Used

- PHP 8.2+

- Laravel 12

- vinkla/hashids (^13.x)

- hashids/hashids (^5.x)

- Composer


## System Requirements


Make sure you have installed:

- PHP 8.2 or higher

- Composer

- MySQL (optional for database usage)

- XAMPP / Laragon / Local server

- Web Browser (Chrome / Edge / Firefox)



---

#  Full Step-by-Step Setup (Laravel 12 + Hashids)

---


## STEP 1: Create Laravel 12 Project

### Open terminal / CMD and run:

```
composer create-project laravel/laravel PHP_Laravel12_Hashids "12.*"

```

### Go inside project:

```
cd PHP_Laravel12_Hashids

```

#### Explanation: 

This command installs a fresh Laravel 12 application using Composer.

The "12.*" ensures that version 12 is installed.




## STEP 2: Database setup optional (not required for demo APIs)

### Open .env and set:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel12_Hashids
DB_USERNAME=root
DB_PASSWORD=

```

### Create database in MySQL / phpMyAdmin:

```
Database name: laravel12_Hashids

```

### then Run Migration:

```
php artisan migrate

```

#### Explanation:

This step configures the database connection in Laravel.

It is optional because this demo does not require database records.






## STEP 3: Install the Hashids Package

### Now install the vinkla/laravel-hashids package:

```
composer require vinkla/hashids

```

#### Explanation:

This command installs the official Laravel Hashids package to enable ID encoding and decoding functionality.




## STEP 4: Publish the Config File

### Publish the vendor config so you can customize salt & settings:

```
php artisan vendor:publish --provider="Vinkla\Hashids\HashidsServiceProvider"

```

### You’ll now see a new config file:

```
config/hashids.php

```

#### Explanation:

This command publishes the package configuration file so you can customize salt, length, and alphabet settings.




## STEP 5: Configure Hashids

### Open config/hashids.php. It looks like this:

```

<?php

return [

    'default' => 'main',

    'connections' => [

        'main' => [
            'salt' => env('HASHIDS_SALT', env('APP_KEY')),
            'length' => 10,
            'alphabet' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',
        ],

    ],

];


```

#### Important Note (Laravel 12 + PHP 8.2+)

- In Laravel 12 with vinkla/hashids (^13.x), the `alphabet` value cannot be `null`.

- It must always be defined as a string.

- If `alphabet` is set to `null`, PHP 8+ strict type checking will throw a TypeError.

#### Example of WRONG configuration:

```
'alphabet' => null,   ❌

```
#### Correct configuration:

```
'alphabet' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',  ✅

```
#### Reason:

The Hashids constructor requires a string type for the alphabet parameter.
Since PHP 8 introduced strict type enforcement, passing null causes an error.




## STEP 6: Cache Clear

### Run:

```
php artisan config:clear

php artisan cache:clear

php artisan optimize:clear

```

#### Explanation:

These commands clear Laravel's cached configuration to ensure new settings are properly applied.



## STEP 7: Create Controller

### Run:

```
php artisan make:controller HashidsController

```

### Open app/Http/Controllers/HashidsController.php:

```

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class HashidsController extends Controller
{
    public function encode($id)
    {
        if (!is_numeric($id)) {
            return response()->json([
                'message' => 'ID must be numeric'
            ]);
        }

        $hash = Hashids::encode($id);

        return response()->json([
            'original_id' => (int) $id,
            'encoded_hash' => $hash
        ]);

    }

    public function decode($hash)
    {
        $decoded = Hashids::decode($hash);

        if (count($decoded) > 0) {
            return response()->json([
                'hash' => $hash,
                'decoded_id' => $decoded[0]
            ]);
        } else {
            return response()->json([
                'message' => 'Invalid or corrupted hash'
            ]);
        }
    }


}

```

#### Explanation:

This controller handles encoding numeric IDs into hashes and decoding hashes back into original IDs.




## STEP 8: Define Routes

### Open routes/web.php and add:

```
use App\Http\Controllers\HashidsController;

Route::get('/encode/{id}', [HashidsController::class, 'encode']);
Route::get('/decode/{hash}', [HashidsController::class, 'decode']);

```
#### Explanation:

Routes define the URLs that trigger the encode and decode functions in the controller.



## STEP 9: Test Proper Way

### Start server:

```
php artisan serve

```

### Now test:

```
http://127.0.0.1:8000/encode/100

```

### Example output:

```
{
  "original_id": 100,
  "encoded_hash": "Bk1K6y420r"
}

```


### Now copy that exact hash and Open:

```
http://127.0.0.1:8000/decode/Bk1K6y420r

```

### Example output:

```
{
  "hash": "Bk1K6y420r",
  "decoded_id": 100
}

```

#### Explanation:

This step runs the Laravel development server and tests the encode and decode functionality using browser URLs.




## Expected Output

### Encode ID Output:


<img width="1919" height="875" alt="Screenshot 2026-02-12 122127" src="https://github.com/user-attachments/assets/522a7660-96f3-4747-9f9c-8b162b284981" />


### Decode ID Output:


<img width="1919" height="862" alt="Screenshot 2026-02-12 113839" src="https://github.com/user-attachments/assets/e0a99f6e-7b52-49a5-a256-854e21839840" />


### If You Enter Wrong Hash:


<img width="1917" height="590" alt="Screenshot 2026-02-12 121426" src="https://github.com/user-attachments/assets/a75f2ea2-ae35-482b-816c-2ec466aece40" />


---

# Project Folder Structure:

```

PHP_Laravel12_Hashids
│
├── app
│   └── Http
│       └── Controllers
│           └── HashidsController.php
│
├── config
│   └── hashids.php
│
├── routes
│   └── web.php
│
├── .env
├── composer.json
└── public

```
