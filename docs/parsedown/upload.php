<?php
require_once 'Parsedown.php';

$target_dir = "how-tos/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Verificar si el archivo ya existe
if (file_exists($target_file)) {
  echo "Lo siento, el archivo ya existe.";
  $uploadOk = 0;
}

// Verificar el tamaño del archivo
if ($_FILES["file"]["size"] > 500000) {
  echo "Lo siento, el archivo es demasiado grande.";
  $uploadOk = 0;
}

// Permitir solo ciertos formatos de archivo
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType != "txt" && $imageFileType != "md") {
  echo "Lo siento, solo se permite subir archivos JPG, JPEG, PNG, GIF, TXT y MD.";
  $uploadOk = 0;
}

// Verificar si $uploadOk es igual a 0 por algún error
if ($uploadOk == 0) {
  echo "Lo siento, el archivo no se pudo subir.";
// Si todo está bien, intentar subir el archivo
} else {
  if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    $filename = $_FILES["file"]["name"];
    $filepath = $target_dir . $filename;

    // Convertir el archivo Markdown a HTML
    if ($imageFileType == "md") {
      $parsedown = new Parsedown();
      $html_content = $parsedown->text(file_get_contents($filepath));
      $filename = pathinfo($filename, PATHINFO_FILENAME) . ".html";
      $filepath = $target_dir . $filename;
      file_put_contents($filepath, $html_content);
    }

    echo "El archivo ". htmlspecialchars(basename($filename)). " ha sido subido correctamente.";

    // Agregar enlace al nuevo post en index.html
    $url = $filename;
    $name = pathinfo($filename, PATHINFO_FILENAME);
    $html = "<a href=\"how-tos/$filename\">$name</a>\n";
    file_put_contents("index.html", $html, FILE_APPEND);
  }
}
?>

