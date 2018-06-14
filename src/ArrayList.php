<?php

/**
 * 
 */
declare(strict_types = 1);

/**
 * show off @method
 *
 * @method bool add(object $e) or void add(int $index, object $element)
 * @method bool remove(object $o) or object remove(int $index)
 */
class ArrayList extends AbstractList implements Listable
{

  private const EMPTY_ELEMENTDATA = [];

  private $E = '';

  private $elementData = [];

  private $size = 0;

  private $position = 0;

  public function __construct(string $E)
  {
    $this->E = $E;
    $this->elementData = self::EMPTY_ELEMENTDATA;
  }

  private function ensureCapacityInternal(int $minCapacity): void
  {
    $this->elementData = array_pad($this->elementData, $minCapacity, null);
  }

  public function __call(string $methodName, array $arguments)
  {
    switch ($methodName) {
      case 'add':
        switch (count($arguments)) {
          case 1:
            return $this->addByObject(...$arguments);
            break;
          case 2:
            $this->addByIndex(...$arguments);
            break;
        }
        break;
      case 'remove':
        switch (gettype($arguments[0])) {
          case 'object':
            return $this->removeByObject($arguments[0]);
            break;
          case 'integer':
            return $this->removeByIndex($arguments[0]);
            break;
          default:
            throw new TypeError($this->wrongType(1, 'object or integer', gettype($arguments[0]), __CLASS__, 'remove()'));
        }
        break;
      default:
        throw new Error($this->undefinedMethod(__CLASS__, $methodName));
    }
  }

  public function size(): int
  {
    return $this->size;
  }

  public function isEmpty(): bool
  {
    return $this->size === 0;
  }

  public function contains(?object $o): bool
  {
    return $this->indexOf($o) >= 0;
  }

  public function indexOf(?object $o): int
  {
    $this->instanceCheck($o);
    
    if ($o === null) {
      for ($i = 0; $i < $this->size; $i++) {
        if ($this->elementData[$i] === null) {
          return $i;
        }
      }
    } else {
      for ($i = 0; $i < $this->size; $i++) {
        if ($o === $this->elementData[$i]) {
          return $i;
        }
      }
    }
    
    return -1;
  }

  public function toArray(): array
  {
    return (new ArrayObject($this->elementData))->getArrayCopy();
  }

  public function get(int $index): object
  {
    $this->rangeCheck($index);
    
    return $this->elementData[$index];
  }

  public function set(int $index, object $element): object
  {
    $this->instanceCheck($element);
    $this->rangeCheck($index);
    
    $oldValue = $this->elementData[$index];
    $this->elementData[$index] = $element;
    return $oldValue;
  }

  private function addByObject(object $e): bool
  {
    $this->instanceCheck($e);
    $this->elementData[$this->size++] = $e;
    return true;
  }

  private function addByIndex(int $index, object $element): void
  {
    $this->instanceCheck($element);
    $this->rangeCheckForAdd($index);
    
    Sys::arraycopy($this->elementData, $index, $this->elementData, $index + 1, $this->size - $index);
    
    $this->elementData[$index] = $element;
    $this->size++;
  }

  private function removeByIndex(int $index): object
  {
    $this->rangeCheck($index);
    
    $this->modCount++;
    $oldValue = $this->elementData[$index];
    
    $numMoved = $this->size - $index - 1;
    
    if ($numMoved > 0) {
      Sys::arraycopy($this->elementData, $index + 1, $this->elementData, $index, $numMoved);
    }
    unset($this->elementData[--$this->size]);
    
    return $oldValue;
  }

  private function removeByObject(?object $o): bool
  {
    $this->instanceCheck($o);
    
    if ($o === null) {
      for ($index = 0; $index < $this->size; $index++) {
        if ($this->elementData[$index] === null) {
          $this->fastRemove($index);
          return true;
        }
      }
    } else {
      for ($index = 0; $index < $this->size; $index++) {
        if ($o === $this->elementData[$index]) {
          $this->fastRemove($index);
          return true;
        }
      }
    }
    return false;
  }

  public function addAll(Collectable $c): bool
  {
    $a = $c->toArray();
    
    array_map(function (object $o): void {
      $this->instanceCheck($o);
    }, $a);
    
    $numNew = count($a);
    $this->ensureCapacityInternal($this->size + $numNew);
    Sys::arraycopy($a, 0, $this->elementData, $this->size, $numNew);
    $this->size += $numNew;
    return $numNew !== 0;
  }

  private function fastRemove(int $index): void
  {
    $this->modCount++;
    $numMoved = $this->size - $index - 1;
    if ($numMoved > 0) {
      Sys::arraycopy($this->elementData, $index + 1, $this->elementData, $index, $numMoved);
      unset($this->elementData[--$this->size]);
    }
  }

  public function clear(): void
  {
    $this->modCount++;
    
    for ($i = 0; $i < $this->size; $i++) {
      unset($this->elementData[$i]);
    }
    
    $this->size = 0;
  }

  public function sort(): void
  {
    usort($this->elementData, function (Comparable $a, Comparable $b): int {
      return $a->compareTo($b);
    });
  }

  private function instanceCheck(?object $element): void
  {
    if ($element !== null && !$element instanceof $this->E) {
      throw new TypeError($this->notInstanceOfMsg(get_class($element)));
    }
  }

  private function rangeCheck(int $index): void
  {
    if ($index >= $this->size) {
      throw new IndexOutOfBoundsException($this->outOfBoundsMsg($index));
    }
  }

  private function rangeCheckForAdd(int $index): void
  {
    if ($index > $this->size || $index < 0) {
      throw new IndexOutOfBoundsException($this->outOfBoundsMsg($index));
    }
  }

  private function outOfBoundsMsg(int $index): string
  {
    return "Index: {$index}, Size: {$this->size}";
  }

  private function notInstanceOfMsg(string $className): string
  {
    return "Object: {$className}, Instance: {$this->E}";
  }

  private function undefinedMethod(string $className, string $methodName): string
  {
    return "Call to undefined method {$className}::{$methodName}";
  }

  private function wrongType(int $argNr, string $expectedType, string $actualType, string $className, string $methodName): string
  {
    return "Argument {$argNr} passed to {$className}::{$methodName} must be of the type {$expectedType}, {$actualType} given";
  }

  public function current(): object
  {
    return $this->elementData[$this->position];
  }

  public function key(): int
  {
    return $this->position;
  }

  public function next(): void
  {
    $this->position++;
  }

  public function rewind(): void
  {
    $this->position = 0;
  }

  public function valid(): bool
  {
    return array_key_exists($this->position, $this->elementData);
  }
}