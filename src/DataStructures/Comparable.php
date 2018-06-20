<?php

/**
 * 
 */
declare(strict_types = 1);

namespace Kappit\JavaLikeDataStructures\DataStructures;

interface Comparable
{

  public function compareTo(Comparable $o): int;
}