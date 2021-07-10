function tamañoFuente(tam) {
  var tam = parseInt(tam);
  document.body.style.fontSize = tam + "px";
}

function colorFondo(color) {
  document.body.style.backgroundColor = color;

  if (color == "lightgray") {
    document.body.style.color = "black";
  }

  if (color == "black") {
    document.body.style.color = "white";
  }

  if (color == "lightblue") {
    document.body.style.color = "purple";
  }

  if (color == "yellow") {
    document.body.style.color = "black";
  }
}

function espacioLineas(tam) {
  document.body.style.lineHeight = tam;
}

function estiloTexto(est) {
  document.body.style.fontFamily = est;
}
