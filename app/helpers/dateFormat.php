<?php

function dateFormat(string $date)
{
  return (new DateTime($date))->format('d/m/Y');
}