# Sistema de Gestão Escolar  
Esse é um projeto de gestão escolar desenvolvido durante a curso de Desenvolvimento de Sistemas da ETEC EaD como requisito obrigatório para a comclusão de curso (TCC).  

## Funcionalidades  
- [ ] Cadastro de funcionários.  
- [ ] Cadastro de professores.  
- [ ] Cadastro de matérias.  
- [ ] Cadastro de aulas.  
- [ ] Cadastro de aluno.  
- [ ] Inclusão de atividades e notas.  
- [ ] Registro de chamadas. 

## Rotas  
  
**Funcionários**  
/dashboard - Visão geral do sistema  
  
/funcionarios - Lista de funcionários  
/funcionarios/{id} - Perfil do funcionário  
/funcionarios/adicionar - Adicionar novo funcionário  
  
/alunos - Lista de alunos  
/alunos/{id} - Perfil do aluno  
/alunos/adicionar - Adicionar novo aluno  
  
/turmas - Lista de turmas  
/turmas/{id} - Detalhes da turma  
/turmas/adicionar - Adicionar nova turma  
  
/materias - Lista de matérias  
/materias/{id} - Detalhes da matéria  
/materias/adicionar - Adicionar nova matéria  
  
/professores - Lista de professores  
/professores/{id} - Perfil do professor  
/professores/adicionar - Adicionar novo professor  
  
/perfil - Perfil  

## Requisitos  
- PHP 7.4  
- Composer 2.1.5  

## Como executar?  
Clone o repositório: `` git clone https://github.com/paularolim/gestao-escolar-php.git ``  
Entre na pasta `` cd gestao-escolar-php ``  
Configure as variáveis de ambiente `` edite o arquivo .env ``  
Instale os pacotes `` composer install ``  
Inicie o servidor `` php -S localhost:8000 ``  