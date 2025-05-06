# Kirby Auctions
Render auctions xml into txt files for [Kirby CMS](https://getkirby.com).

## Installation

Copy plugin files to your plugin's directory or install via composer with `composer require eco-remi/kirby-auctions`

If copied, install symfony dependency with composer

```
composer install
```

## Usage

You must have a export.xml in a FTP folder

Run synchronisation with
```
php site/plugins/kirby-auctions/run-sync.php
```

That will create forlder and txt files needed for kirby rendering
