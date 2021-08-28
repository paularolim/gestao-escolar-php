<?php


namespace App\Controllers;

use App\Http\Request;
use App\Utils\View;
use App\Models\Employee;
use App\Models\Teacher;
use App\Sessions\EmployeeSession;

class EmployeesController
{
  const PROFILE = 'employee';

  public static function getDashboard(): string
  {
    $content = View::render('pages/dashboard-employee');
    return LayoutController::getLayout(self::PROFILE, 'Dashboard', $content);
  }

  private static function getTeachersRows(): string
  {
    $teachers = Teacher::getAll();

    
    $rows = '';
    foreach ($teachers as $teacher) {
      $rows .= View::render('pages/employee/components/table-tr-teachers', [
        'id' => $teacher['id'],
        'name' => $teacher['name'],
        'formation' => $teacher['formation']
      ]);
    }

    return $rows;
  }

  public static function getTeachers(): string
  {
    $content = View::render('pages/employee/list-teachers', [
      'rows' => self::getTeachersRows()
    ]);
    return LayoutController::getLayout(self::PROFILE, 'Professores', $content);
  }

  public static function getAddTeacher(): string
  {
    $content = View::render('pages/employee/add-teacher');
    return LayoutController::getLayout(self::PROFILE, 'Professores', $content);
  }

  public static function setAddTeacher(Request $request): void
  {
    echo '<pre>';
    print_r($request->getPostVars());
    echo '</pre>';
    $postVars = $request->getPostVars();

    $name = $postVars['name'] ?? '';
    $birthDate = $postVars['birthDate'] ?? '';
    $document = $postVars['document'] ?? '';
    $email = $postVars['email'] ?? '';
    $formation = $postVars['formation'] ?? '';

    $teacher = new Teacher($name, $birthDate, $document, $email, $formation);

    try {
      $teacher->store();
    } catch (\Error $error) {
      $request->getRouter()->redirect('/funcionarios/professores/adicionar');
    }
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
