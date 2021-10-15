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
      'size' => $this->size
    ];
  }

  public function render(string $baseURL)
  {
    $rightButton = View::render('layouts/components/pagination-right-button', [
      'URL' => $baseURL,
      'page' => $this->page + 1,
      'size' => $this->size,
      'disable' => $this->page === $this->totalPages ? 'w3-hide' : ''
    ]);

    $leftButton = View::render('layouts/components/pagination-left-button', [
      'URL' => $baseURL,
      'page' => $this->page - 1,
      'size' => $this->size,
      'disable' => $this->page === 1 ? 'w3-hide' : ''
    ]);

    $numberButtons = '';
    for ($i = 0; $i < $this->totalPages; $i++) {
      $numberButtons .= View::render('layouts/components/pagination-number-button', [
        'URL' => $baseURL,
        'page' => $i + 1,
        'size' => $this->size,
        'active' => $this->page === ($i + 1) ? 'w3-blue' : ''
      ]);
    }

    return $leftButton . $numberButtons . $rightButton;
  }
}
