<?php

/**
 * 
 */
declare(strict_types = 1);

class IndexOutOfBoundsException extends RuntimeException
{

  public function __construct(string $s)
  {
    parent::__construct($s);
  }
}