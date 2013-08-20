byter
=====
A little helper for your byte conversion needs.

Initially built for a project I'm working for.

###Usage
```php
// Create a new Byter from "bytes".
$byter = Byter::fromBytes(1024);

// Transform into kilobytes.
var_dump( $byter->toKB() ); // int(1)

// Output in binary (bi-bytes).
var_dump( $byter->useBinary()->toKB() ); // float(1.024)


// Create a new byter from string.
$byter = Byter::fromString('33GB');

// Transform into megabytes.
var_dump( $byter->toMB() ); // int(33792)

// Output in bi-bytes.
var_dump( $byter->useBinary()->toMB() ); // float(35433.480192)
```

###`Byter::fromString($string)`
Byter's `fromString` method is smart enough to work with:
```
1GB
1 GB
1.1 GB
1,1 GB
1.323124141313 GiB
3 B
```
It will lookup two parts within the given string:
 1. Digits, dots, commas.
 2. Ending lowercase, uppercase letters.

Behind the scenes, Byter will transform commas into dots and dotted numbers to floats, otherwise to integers. It will also resolve bi-bytes.
