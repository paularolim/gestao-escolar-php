<?php

namespace App\Utils;

class Pagination
{
  private int $totalItems;
  private int $totalPages;
  private int $startItem;
  private int $size;
  private int $page;

  public function __construct(int $page, int $size, int $totalItems)
  {
    $this->size = $size;
    $this->page = $page;
    $this->totalItems = $totalItems;
    $this->calculate();
  }

  private function calculate()
  {
    $this->totalPages = ceil($this->totalItems / $this->size);
    $this->startItem = ($this->size * $this->page) - $this->size;
  }

  public function limit()
  {
    return $this->startItem . ',' . $this->size;
  }

  public function getInfo(): array
  {
    return [
      'current' => $this->page,
      'prev' => $this->page === 1 ? 1 : $this->page - 1,
      'next' => $this->page === $this->totalPages ? $this->page : $this->page + 1,
      'size' => $this->size,
      'total' => $this->totalPages
    ];
  }
}
