# Neos comments
[![Latest Stable Version](https://poser.pugx.org/breadlesscode/neos-commentable/v/stable)](https://packagist.org/packages/breadlesscode/neos-commentable)
[![Downloads](https://img.shields.io/packagist/dt/breadlesscode/neos-commentable.svg)](https://packagist.org/packages/breadlesscode/neos-commentable)
[![License](https://img.shields.io/github/license/breadlesscode/neos-commentable.svg)](LICENSE)
[![GitHub stars](https://img.shields.io/github/stars/breadlesscode/neos-commentable.svg?style=social&label=Stars)](https://github.com/breadlesscode/neos-commentable/stargazers)
[![GitHub watchers](https://img.shields.io/github/watchers/breadlesscode/neos-commentable.svg?style=social&label=Watch)](https://github.com/breadlesscode/neos-commentable/subscription)

A package for Neos CMS for commenting nodes.

## Installation
Most of the time you have to make small adjustments to a package (e.g., the configuration in Settings.yaml). Because of that, it is important to add the corresponding package to the composer from your theme package. Mostly this is the site package located under Packages/Sites/. To install it correctly go to your theme package (e.g.Packages/Sites/Foo.Bar) and run following command:

```bash
composer require breadlesscode/neos-commentable --no-update
```

The --no-update command prevent the automatic update of the dependencies. After the package was added to your theme composer.json, go back to the root of the Neos installation and run composer update. Your desired package is now installed correctly.

## Usage
Coming soon

## License
The MIT License (MIT). Please see [License File](LICENSE) for more information.
