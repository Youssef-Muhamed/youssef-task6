<?php
session_start();
require 'dbConnect.php';

$id = $_GET['id'];
    $sql = "select * from user where id = $id";
    $op   = mysqli_query($con,$sql);
    if(mysqli_num_rows($op) == 1){

        $sql = "delete from user where id = $id ";
        $op  = mysqli_query($con,$sql);

        if($op){
            $message = 'raw deleted';
        }else{
            $message = 'error Try Again !!!!!! ';
        }
    }else{
        $message = 'Error In User Id ';
    }
$_SESSION['Message'] = $message;

header("Location: index.php");