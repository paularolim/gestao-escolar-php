function formatDocument(document) {
  document = document.replace(/\D/g, "")                    // Remove tudo o que não é dígito
  document = document.replace(/(\d{3})(\d)/, "$1.$2")       // Coloca um ponto entre o terceiro e o quarto dígitos
  document = document.replace(/(\d{3})(\d)/, "$1.$2")       // Coloca um ponto entre o terceiro e o quarto dígitos
  document = document.replace(/(\d{3})(\d{1,2})$/, "$1-$2") //Coloca um hífen entre o terceiro e o quarto dígitos
  return document
}

function formatPhone(phone) {
  phone = phone.replace(/\D/g, "")                 //Remove tudo o que não é dígito
  phone = phone.replace(/^(\d\d)(\d)/g, "($1) $2") //Coloca parênteses em volta dos dois primeiros dígitos
  phone = phone.replace(/(\d{5})(\d)/, "$1-$2")    //Coloca hífen entre o quarto e o quinto dígitos
  return phone
}

function formatDate(date) {
  date = date.split('-')
  date = date.reverse()
  date = date.join('/')
  return date;
}