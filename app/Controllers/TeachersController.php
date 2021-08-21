<?php

namespace App\Controllers;

use App\Http\Request;
use App\Models\Teacher;
use App\Sessions\TeacherSession;
use App\Utils\View;

class TeachersController
{
  public static function getDashboard(): string
  {
    $content = View::render('pages/dashboard-teachers');
    return LayoutController::getLayout('teacher', 'Gestão Escolar - Dashboard', $content);
  }

  public static function setLogin(Request $request)
  {
    // post vars
    $postVars = $request->getPostVars();
    $document = $postVars['document'] ?? '';
    $password = $postVars['password'] ?? '';

    // search by document
    $person = Teacher::getByDocument($document);

    // if document is wrong
    if (!$person instanceof Teacher)
      return HomeController::getHome('teacher', 'Documento ou senha inválidos');

    if (!password_verify($password, $person->password))
      return HomeController::getHome('teacher', 'Documento ou senha inválidos');

    TeacherSession::login($person);

    // redirect to teacher home if login success
    $request->getRouter()->redirect('/professores');
  }

  public static function setLogout(Request $request)
  {
    TeacherSession::logout();

    $request->getRouter()->redirect('/');
  }
}
