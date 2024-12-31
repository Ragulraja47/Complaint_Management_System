<?php
include("db.php");


if(isset($_POST["count"])){
    $id = $_POST['id'];
    $query = "SELECT * FROM complaints_detail WHERE worker_id='$id' AND status='16'";
    $query_run = mysqli_query($conn,$query);
    $count = mysqli_num_rows($query_run);
    $res=[
        "status"=>200,
        "data"=>$count
    ];
    echo json_encode($res);
}

if(isset($_POST['fratings'])){
    $id=$_POST['id'];
    $query = "SELECT sum(rating) AS total FROM complaints_detail WHERE worker_id='$id'";
    $query_run = mysqli_query($conn,$query);
    $count_data = mysqli_fetch_assoc($query_run);
    $total = $count_data['total']??0;
    $res=[
        "status"=>200,
        "data"=>$total
    ];
    echo json_encode($res);
}

if(isset($_POST['mratings'])){
    $id=$_POST['id'];
    $query = "SELECT sum(mrating) AS total FROM complaints_detail WHERE worker_id='$id'";
    $query_run = mysqli_query($conn,$query);
    $count_data = mysqli_fetch_assoc($query_run);
    $total = $count_data['total']??0;
    $res=[
        "status"=>200,
        "data"=>$total
    ];
    echo json_encode($res);
}

if(isset($_POST['average'])){
    $id=$_POST['id'];
    $query = "SELECT round(avg(rating+mrating),1) AS average FROM complaints_detail WHERE worker_id='$id'";
    $query_run = mysqli_query($conn,$query);
    $avg_data = mysqli_fetch_assoc($query_run);
    $average = $avg_data['average']??0;
    $res=[
        "status"=>200,
        "data"=>$average,
    ];
    echo json_encode($res);
}



?>