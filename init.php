<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mysql = new mysqli("localhost", "root", "", "chatGPT");
$mysql->query("SET NAMES 'utf8'");

// ///////#DATA_BASE_chatGPT
 $sql = "CREATE DATABASE chatGPT";

// //////#ТАБЛИЦА_MESSAGES
$sql = "CREATE TABLE messages (
    id_messages INT PRIMARY KEY AUTO_INCREMENT,
    text text NOT NULL,
    id_user_to INT,
    id_user_from INT,
    created_at datetime
)";

//////#ТАБЛИЦА_USERS
$sql = "CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    login VARCHAR(20) NOT NULL,
    password VARCHAR(20)NOT NULL,
    name VARCHAR(20)NOT NULL,
    avatar VARCHAR(20)NOT NULL
)";

//////#ТАБЛИЦА_GALLERY
$sql = "CREATE TABLE gallery (
    id_img INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    name VARCHAR(20)NOT NULL,
    path VARCHAR(20)NOT NULL
)";

$mysql->close();
?>