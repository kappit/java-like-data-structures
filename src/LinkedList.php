<?php

/**
 * 
 */
declare(strict_types = 1);

class LinkedList
{

  private $E = '';

  private $size = 0;

  private $first;

  private $last;

  public function __construct(string $E)
  {
    $this->E = $E;
  }
}