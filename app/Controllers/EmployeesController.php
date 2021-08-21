<?php


namespace App\Controllers;

use App\Http\Request;
use App\Utils\View;
use App\Models\Employee;
use App\Sessions\EmployeeSession;

class EmployeesController
{
  public static function getDashboard(): string
  {
    $content = View::render('pages/dashboard-employee');
    return LayoutController::getLayout('employee', 'Gestão Escolar - Dashboard', $content);
  }

  public static function setLogin(Request $request)
  {
    // post vars
    $postVars = $request->getPostVars();
    $document = $postVars['document'] ?? '';
    $password = $postVars['password'] ?? '';

    // search by document
    $person = Employee::getByDocument($document);

    // if document is wrong
    if (!$person instanceof Employee)
      return HomeController::getHome('employee', 'Documento ou senha inválidos');

    if (!password_verify($password, $person->password))
      return HomeController::getHome('employee', 'Documento ou senha inválidos');

    EmployeeSession::login($person);

    // redirect to employee home if login success
    $request->getRouter()->redirect('/funcionarios');
  }

  public static function setLogout(Request $request)
  {
    EmployeeSession::logout();

    $request->getRouter()->redirect('/');
  }
}
