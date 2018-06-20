<?php

/**
 * 
 */
declare(strict_types = 1);

namespace Kappit\JavaLikeDataStructures\DataStructures;

abstract class AbstractList
{

  protected function __construct()
  {}

  protected $modCount = 0;
}