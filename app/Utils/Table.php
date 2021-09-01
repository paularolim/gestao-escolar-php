<?php

namespace App\Utils;

class Table
{
  private array $headers;
  private array $data;
  private string $url;

  public function __construct(array $headers, array $cells, array $data, string $url)
  {
    $this->headers = $headers;
    $this->cells = $cells;
    $this->data = $data;
    $this->url = $url;
  }

  private function getHeader(): string
  {
    $header = '';
    for ($i = 0; $i < count($this->headers); $i++) {
      $header .= View::render('layouts/components/table-th', [
        'field' => $this->headers[$i]
      ]);
    }

    return $header;
  }

  private function getCells($dataRow): string
  {
    $cells = '';
    for ($i = 0; $i < count($this->headers); $i++) {
      if ($this->cells[$i] !== 'button') {
        $cells .= View::render('layouts/components/table-td', [
          'field' => $dataRow[$this->cells[$i]]
        ]);
      }
      else {
        $cells .= View::render('layouts/components/table-td-button', [
          'url' => $this->url,
          'id' => $dataRow['id']
        ]);
      }
    }

    return $cells;
  }

  private function getRows(): string
  {
    $rows = '';
    for ($i = 0; $i < count($this->data); $i++) {
      $rows .= View::render('layouts/components/table-tr', [
        'cells' => $this->getCells($this->data[$i])
      ]);
    }

    return $rows;
  }

  public function render(): string
  {
    return View::render('layouts/components/table', [
      'header' => $this->getHeader(),
      'rows' => $this->getRows()
    ]);
  }
}
