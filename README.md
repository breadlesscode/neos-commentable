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

### 1. Extend your document
You have to add the mixin `Breadlesscode.Commentable:Mixin.Commentable` to your commentable node. This mixin in simply
adds a child node where the comments are stored.

### 2. Render the comments
Now you can add a the `Breadlesscode.Commentable:Collection.Comment` Fusion-Prototype to your node. This is a simple 
`Neos.Neos:ContentCollection` which lists the comments.

### 3. Add the form
This Package provides a simple form implementation `Breadlesscode.Commentable:Form.Comment`. This form adds the comment
to the current document node comment collection. You can simply add a finisher by extend the Fusion-Prototype:

```neosfusion
prototype(Breadlesscode.Commentable:Form.Comment) {
    finishers {
        sayThankYou = Neos.Form.Builder:FlashMessageFinisher.Definition {
            options {
                messageTitle = 'Thank you!'
                messageBody = 'Thanks for your comment'
            }
        }
    }
}
``` 
 
If you want to use your own Form implementation, you should add the correct finisher
`Breadlesscode.Commentable:From.Finisher.AddComment`. 

## Configuration

```yaml
Breadlesscode:
  Commentable:
    # should the comment be added to the top?
    addToTop: true
    # should comments be hidden by default
    hidden: true
```

## License
The MIT License (MIT). Please see [License File](LICENSE) for more information.
