# SCIE SGlide

A simple helper function for safely generating Statamic glide image urls from fields as well as path strings.

## Installation

```
composer require stuartcusackie/sglide
```

## Publish

Don't forget to publish the config file and the missing image placeholder.

```
php artisan vendor:publish
```

## Config

Set up your config file: config/sglide.php

## Filesystems

If you want to use the default disk in the config file, i.e. 'assets', then you'll need to set up the filesystem in config/filesystem.php.

```
'assets' => [
    'driver' => 'local',
    'root' => public_path('assets'),
    'url' => '/assets',
    'visibility' => 'public',
],
```

This allows you to create glide images from your website's public folder.

## Usage

** Using a Statamic Asset field inline **
```
<img src="{{ sglide($imageField, ['width' => 400, 'height' => 300, 'fm' => 'webp', 'fit' => 'crop'])->url }}" alt="XX" />
```

** Using a Statamic Asset in a component **
```
$this->imageUrl = sglide($imageField, [
    'width' => 700,
    'height' => 933,
    'fm' => 'webp',
    'fit' => 'crop_focal'
])->url;
```

** Using a path string **
```
<img src="{{ sglide('images/image1.jpg', ['width' => 400, 'height' => 300, 'fm' => 'webp', 'fit' => 'crop'])->url }}" alt="XX" />
```
