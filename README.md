# walnut-lib-fileaccessor
A tiny wrapper for basic CRUD-like file manipulations

```php
$fileAccessor = new PhpFileAccessor;
$fileName = 'test.txt';
$content = 'Test content.';

$fileAccessor->fileExists($fileName); //false

$fileAccessor->writeToFile($fileName, $content);
$fileAccessor->fileExists($fileName); //true

$fileAccessor->readFromFile($fileName)); //Test content.
$fileAccessor->removeFile($fileName);
$fileAccessor->fileExists($fileName); //false
```