<?php

/**
 * 
 */
declare(strict_types = 1);

namespace Kappit\JavaLikeDataStructures\DataStructures;

class ArrayIndexOutOfBoundsException extends IndexOutOfBoundsException
{

  public function __construct(int $index)
  {
    parent::__construct("Array index out of range: {$index}");
  }
}