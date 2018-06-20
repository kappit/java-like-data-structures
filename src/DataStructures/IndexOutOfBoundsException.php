<?php

/**
 * 
 */
declare(strict_types = 1);

namespace Kappit\JavaLikeDataStructures\DataStructures;

class IndexOutOfBoundsException extends RuntimeException
{

  public function __construct(string $s)
  {
    parent::__construct($s);
  }
}