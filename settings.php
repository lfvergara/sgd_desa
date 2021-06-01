<?php

const DB_HOST = "localhost";
const DB_USER = "desadoc";
const DB_PASS = "digital29";
const DB_NAME = "desa_documentos";

const APP_NAME = "sgd_desa";
const THEME_PATH = "/sgd_desa/static/theme";
const FILES_PATH = "/home/cpcelr/private_desa/";
const DEFAULT_MODULE = "archivos";
const DEFAULT_ACTION = "ingresar";

const ALG_USER = "crc32";
const ALG_PASS = "sha512";
const ALG_TOKEN = "md5";

const SO_UNIX = false;
const TEMPLATE = "static/template.html";

define('MB', 1048576);
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
ini_set('include_path', DOCUMENT_ROOT);
date_default_timezone_set("America/Argentina/Buenos_Aires");

session_start();
if(!isset($_SESSION[md5(APP_NAME)])) $_SESSION[md5(APP_NAME)] = false;
?>