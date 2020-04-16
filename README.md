# LoremRicksum in Laravel

As a fan of Rick & Morty I wanted to be able to use 
[LoremRicksum](http://loremricksum.com/) in Laravel to dynamically 
generate funny quotes in seeders or live in a demo-page (i.e. with 
random number of paragraphs and quotes)
  
## Facade

The package service provider registers the facade with autoloading.
You can use the following methods:
- ```LoremRicksum::getPlaintext($paragraphs=1, $quotes=3)```  
- ```LoremRicksum::getHtml($paragraphs=1, $quotes=3)```

## Testing

- implemented with/for Laravel 6 LTS. I guess it is compatible with later versions
- I did not implement any unit-tests for the sake of simplicity - it is just for fun and not meant for any production systems ;-)
- I only used assertions to prevent unwanted behaviour if the api breaks (unavailable, new calls)

## Thanks

Many thanks to [@emillinden](https://twitter.com/emillinden) and 
[@adameriksson](https://twitter.com/adameriksson) for the creation of the
api :-)