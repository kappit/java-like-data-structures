<?php

/**
 * 
 */
declare(strict_types = 1);

class Collections
{

  public static function sort(Listable $list): void
  {
    $list->sort();
  }
}