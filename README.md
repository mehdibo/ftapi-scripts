# FtApi Scripts
A set of scripts to get data from 42's API

# Getting started

## Install composer

This library uses Composer to manage its dependencies, so [Install Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos).

## Install dependencies

`cd` to the project's folder and run:

```
composer install
```

## Configure credentials

You first need to [Register a new app](https://profile.intra.42.fr/oauth/applications/new) to get your credentials.
Rename `.env.example` to `.env` and fill it with your details.

# Creating scripts
You can take a look at `script_template` for a quick example.

To send a **POST** request use:

```php
$data = ['key' => 'value'];
$response = $intraRequest->post('/api/uri', $data);
```

To send a **GET** request use:

```php
$data = ['key' => 'value'];
$response = $intraRequest->get('/api/uri', $data);
```

The `$response` contains the raw text, so if you want to use it you will probably need to decode it:

```php
$response = json_decode($response);
```