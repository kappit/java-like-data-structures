<?php

/**
 * 
 */
declare(strict_types = 1);

namespace Kappit\JavaLikeDataStructures\DataStructures;

interface Collectable extends \Iterator
{

  function size(): int;

  function isEmpty(): bool;

  function contains(?object $o): bool;

  function toArray(): array;
}