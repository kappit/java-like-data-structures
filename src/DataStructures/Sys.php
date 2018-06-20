<?php

/**
 * 
 */
declare(strict_types = 1);

class Sys
{

  public static function arraycopy(array $src, int $srcPos, array &$dest, int $destPos, int $length): void
  {
    for ($i = $destPos, $j = $srcPos; $j < $srcPos + $length; $i++, $j++) {
      if ($i >= count($dest)) {
        throw new ArrayIndexOutOfBoundsException($i);
      }
      
      if ($j >= count($src)) {
        throw new ArrayIndexOutOfBoundsException($j);
      }
      
      $dest[$i] = $src[$j];
    }
  }
}