# Etten\Doctrine

Provides some helpers and extension for Doctrine 2 ORM into Nette Framework.

## Installation

First install package via Composer:

`$ composer require etten/doctrine`

Then register required extensions, for example:

```yaml
# app/config.neon

extensions:
	etten.doctrine.uuid: Etten\Doctrine\DI\UuidExtension
```
