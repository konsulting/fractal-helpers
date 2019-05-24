# Fractal Helpers
A small extension for (Fractal)[https://fractal.thephpleague.com] that makes it easy to include relationships on a resource.
Designed for use with Laravel/Eloquent, but it will work with any model or resource that expresses the same interface for retrieving relationships.

## Installation
`composer require konsulting/fractal-helpers`

## Usage
To make use of this package, in your transformers extend `Konsulting\FractalHelpers\TransformerAbstract` rather than the base Fractal transformer.

When building up APIs with Fractal I found myself repeating the same code to include relations on my Eloquent models:

```php
// BookTransformer.php

protected $availableIncludes = [
    'author',
    'characters'
];

public function includeAuthor(Book $book) {
     return $this->item($book->author, new AuthorTransformer);
}

public function includeCharacters(Book $book) {
    return $this->collection($book->characters, new CharacterTransformer);
}
```

With the included `TransformerAbstract` class, you can express the above code more succinctly as:

```php
// BookTransformer.php

protected $itemIncludes = [
    'author' => AuthorTransformer::class,
];

protected $collectionIncludes = [
    'characters' => CharacterTransformer::class,
];
```

## Null relationships
If a relationship returns `null`, it will automatically be converted to a `League\Fractal\Resource\NullResource` object rather than passing to the associated transformer for that relationship.
This means it's not necessary to check for null within each transformer.
