<?php
// Correction TP5
session_start(); 
$host='localhost';
$user = "root";
$password = "";
$base = "BaseDeDonnee";
$link = connexion_MySQLi_procedural($host, $user,$password,$base);

// Style PROCEDURAL
function connexion_MySQLi_procedural ($host, $user,$password,$base)
{
  $link = mysqli_connect($host,$user,$password,$base);
  // Check connection
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
  }
  mysqli_query($link,"SET NAMES 'utf8'");
  return $link;
}

// Renvoie un tableau en 2D
if (!function_exists("GetSQL")) {
  function GetSQL($sql, &$tab)
	{
	  global $link; 
		$result = mysqli_query($link,$sql) or die($sql.'<br>'.mysqli_error($link)) ; $row = mysqli_fetch_array($result);
		$nbEnr = mysqli_num_rows($result);
		$k=0;
		$tab[$k] = $row;
		$k++;
		while ( $row = mysqli_fetch_array($result))
		{ 
			$tab[$k] = $row;
			$k++;
		}
    return $nbEnr;
  }
}

// Pratique quand la requête ne renvoie qu'un enregistrement, 
if (!function_exists("GetSQLValue")) {
	function GetSQLValue($sql)
	{
		global $link;
		$result = mysqli_query($link,$sql) or die('<pre>'.$sql.'</pre><hr>'.mysqli_error($link)) ; 
		$row = mysqli_fetch_array($result);
		if (isset($row[0]))
			return $row[0];
		else
	  	return;
  }
}

// Exécute la requête SQL et renvoie true en cas de succès, false en cas d'échec
if (!function_exists("ExecuteSQL")) {
  function ExecuteSQL($sql)
  {
      global $link;
      $result = mysqli_query($link, $sql);
      if ($result) {
          return true; // Retourne true si la requête est un succès
      } else {
          return false; // Retourne false si la requête a échoué
      }
  }
}



if (!function_exists("QuoteStr")) {
  function QuoteStr($theValue, $theType="text", $theDefinedValue = "", $theNotDefinedValue = "") 
  {
  global $link;
  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($link, $theValue) : mysqli_escape_string($link, $theValue);
  switch ($theType) 
  {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      reak;
  }
  return $theValue;
  }
}

if (!function_exists("EstConnecte")) {
	function EstConnecte() 
	{
	// si pas connecté, redirection vers index.html
	if (!isset($_SESSION['isConnected']))
    header("location: index.html");
		return;
	}
}
?>
