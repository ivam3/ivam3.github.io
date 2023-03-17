<?php
$target_dir = "how-to/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Verificar si el archivo es un archivo de imagen
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["file"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Verificar si el archivo ya existe
if (file_exists($target_file)) {
  echo "Sorry :(, file already exists.";
  $uploadOk = 0;
}

// Verificar el tamaño del archivo
if ($_FILES["file"]["size"] > 500000) {
  echo "Sorry, file is too big.";
  $uploadOk = 0;
}

// Permitir solo ciertos formatos de archivo
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType != "txt" && $imageFileType != "md") {
  echo "Sorry, the file have to be JPG, JPEG, PNG, GIF, TXT or MD.";
  $uploadOk = 0;
}

// Verificar si $uploadOk es igual a 0 por algún error
if ($uploadOk == 0) {
  echo "Sorry, file can not be uploaded.";
// Si todo está bien, intentar subir el archivo
} else {
  if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["file"]["name"])). " was uploaded.";

    // Agregar enlace al nuevo post en index.html
    $url = "how-to/" . basename($_FILES["file"]["name"]);
    $name = pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME);
    $content = '<div class="how-to"><h3><a href="' . $url . '">' . $name . '</a></h3></div>';

    $file = 'index.html';
    // Obtener contenido actual de index.html
    $current = file_get_contents($file);
    // Insertar el nuevo contenido al principio de la sección "Últimos how-tos"
    $pos = strpos($current, '<!-- Ultimos how-tos -->');
    $current = substr_replace($current, $content, $pos, 0);
    // Escribir el contenido actualizado en index.html
    file_put_contents($file, $current);
  }
}
?>
