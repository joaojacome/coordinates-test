# What is this?
A simple coordinates class.

# Usage
---
### Instantiating the class

```php
<?php
$coords = new Coordinates(52.516601, 13.377697);
```
### Measuring distance between two points
```php
<?php
$coords1 = new Coordinates(52.516601, 13.377697);
$coords2 = new Coordinates(52.519213, 13.403575);
$distance = $coords1->getDistanceTo($coords2); //1.77492
//the resulting value can be rounded to X digits
$distance = $coords1->getDistanceTo($coords2, 2); //1.77
```
### Checking if a point is within X meters from another point
```php
<?php
$coords1 = new Coordinates(52.516601, 13.377697);
$coords2 = new Coordinates(52.519213, 13.403575);
$distance = $coords1->isWithinDistance($coords2, 10); //true
$distance = $coords1->isWithinDistance($coords2, 1); //false
```
