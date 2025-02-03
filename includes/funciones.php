<?php

// Imprime los arreglos mas bonitos
function prettyPrint($mensaje, $modo = 0)
{
  if ($modo == 0) {
    echo "<pre style='background-color: #000; color: #fff;'>";
    var_dump($mensaje);
    echo "</pre>";
  } else {
    echo "<pre>";
    var_export($mensaje);
    echo "</pre>";
  }


  //Imprimir array en la consola
  $object = json_encode($mensaje);
  print_r('<script>console.log(' . $object . ')</script>');
}

function dump($mensaje, $modo = 0)
{
  if ($modo == 0) {
    echo "<pre style='background-color: #000; color: #fff;'>";
    var_dump($mensaje);
    echo "</pre>";
  } else {
    echo "<pre>";
    var_export($mensaje);
    echo "</pre>";
  }

  //Imprimir array en la consola
  $object = json_encode($mensaje);
  print_r('<script>console.log(' . $object . ')</script>');

  exit;
}
/**
 * Sanitiza el HTML (convierte etiquetas HTML a entidades)
 *
 * @param string $html El string que se va a sanitizar
 * @return string El string sanitizado
 */
function s($html): string
{
  $s = htmlspecialchars($html);
  return $s;
}



function asset($path)
{
  $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://";  // Verifica si es HTTPS
  $baseUrl .= $_SERVER['HTTP_HOST'];  // Obtiene el dominio actual

  // Asegura que el path no tenga barra inicial
  $path = ltrim($path, '/');

  // Verifica si existe la carpeta `public`
  if (is_dir(__DIR__ . '/public')) {
    return $baseUrl . '/public/' . $path;
  } else {
    return $baseUrl . '/' . $path;  // En caso de que no haya carpeta 'public'
  }
}



if (!function_exists('public_path')) {
  /**
   * Get the path to the public directory.
   *
   * @param string $path
   * @return string
   */
  function public_path($path = '')
  {
    // Obtén la ruta base del proyecto
    $basePath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'public';

    // Normaliza el $path reemplazando '/' o '\' por DIRECTORY_SEPARATOR
    $normalizedPath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);

    // Devuelve la ruta base, con o sin un subdirectorio o archivo
    return $normalizedPath ? $basePath . DIRECTORY_SEPARATOR . ltrim($normalizedPath, DIRECTORY_SEPARATOR) : $basePath;
  }
}

function isMethod($method)
{
  $actualMehod = $_SERVER['REQUEST_METHOD'];
  return $actualMehod === strtoupper($method);
}


function validarORedireccionar($parametro, $urlRedireccion): int
{
  // Validar si el parámetro existe y es un entero válido
  $id = filter_var($parametro, FILTER_VALIDATE_INT);

  if ($id === false) {
    // Redirigir si el ID no es válido
    header("Location: $urlRedireccion");
    exit;
  }

  return $id;
}

function redirect($url, $statusCode = 302)
{
  if (!filter_var($url, FILTER_VALIDATE_URL) && !filter_var($url, FILTER_VALIDATE_DOMAIN)) {
    throw new InvalidArgumentException("The provided URL is not valid.");
  }

  // Set the HTTP status code
  http_response_code($statusCode);

  // Add the Location header for redirection
  header("Location: $url");

  // Stop further execution of the script
  exit();
}

function startSession()
{
  if (!isset($_SESSION)) {
    session_start();
  }
}


function isAuth()
{
  if (!isset($_SESSION['login'])) {
    header('Location: /');
  }
}

function esUltimo($actual,$proximo)
{
  if($actual !== $proximo){
    return true;
  }
  return false;
}
