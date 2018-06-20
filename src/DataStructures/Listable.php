<?php

/**
 * 
 */
declare(strict_types = 1);

namespace Kappit\JavaLikeDataStructures\DataStructures;

interface Listable extends Collectable
{

  function size(): int;

  function isEmpty(): bool;

  function contains(?object $o): bool;

  function toArray(): array;

  function addAll(Collectable $c): bool;

  function clear(): void;

  function get(int $index): object;

  function set(int $index, object $element): object;

  function indexOf(object $o): int;
}