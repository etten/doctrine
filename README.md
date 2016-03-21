# Etten\Doctrine

Provides some helpers and extension for Doctrine 2 ORM into Nette Framework.

## Installation

First install package via Composer:

`$ composer require etten/doctrine`

## Helpers

### FieldOrderHelper

Sometimes, you need sort items by order given by another array.
 
In MySQL, you can use [ORDER BY FIELD](http://dba.stackexchange.com/questions/109120/how-does-order-by-field-in-mysql-work-internally).

But when we use Doctrine, our code should be platform independent and we shouldn't use DBMS-specific functions directly.

You can sort items in PHP via `Etten\Doctrine\Helpers\FieldOrderHelper`. See [implementation](src/Helpers/FieldOrderHelper.php).

*Note: This kind of operations in PHP is inefficient. Use it only for few filtered items.*
*If you have hundreds of items, rather rewrite the code and sort items directly in DBMS, not in PHP.*

## Extensions

### UUID

If you need item's ID before persist and flush, you can use [UUID](https://en.wikipedia.org/wiki/Universally_unique_identifier) as primary index.

Doctrine 2 has native support of UUID (GUID) but it's auto-generated value by RDMS. And we don't know the ID before persist and flush.

But you can generate UUID before persist and flush, in PHP.

For more information see [ramsey/uuid-doctrine](https://github.com/ramsey/uuid-doctrine).

You can add the UUID support by registering a Nette DI extension:

```yaml
# app/config.neon

extensions:
	etten.doctrine.uuid: Etten\Doctrine\DI\UuidExtension
```
