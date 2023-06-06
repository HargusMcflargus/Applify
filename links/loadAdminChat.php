<?php

    include 'dataConnector.php';
    session_start();
    $data = new dataConnector();

    $results = $data->select("messages", "link like '%".$_GET['username']."%';");
    $messages = array();
    while ($row = $results->fetch_assoc()) {
        $names = explode("-", $row['link']);
        $temp = $names[0] == 'admin' ? True : False;
        array_push($messages,  array($temp, $row['message']));
    }
    $newSTUFF = "";
    foreach ($messages as $thing) {
        if ($thing[0]) {
            $newSTUFF .= "

                <div class='row justify-content-end align-items-center'>
                    <div class='col-4 shadow rounded border border-1 my-2 py-2 px-4' style='background-color: #3486eb;'>
                        <span>". $thing[1] ."</span>
                    </div>
                </div>
            
            ";
        }else{
            $newSTUFF .= "
            
                <div class='row justify-content-start align-items-center'>
                    <div class='col-4 bg-white shadow rounded border border-1 my-2 py-2 px-4' style='background-color: #3486eb;'>
                        <span>". $thing[1] ."</span>
                    </div>
                </div>
            
            ";
        }
    }

    $newSTUFF .= "

        <div class='row justify-content-center align-items-center p-0 m-0 mt-3'>
            <div class='col w-100'>
                <form action='links/sendAdmin.php' method='POST' class='container-fluid'>
                    <div class='row justify-content-between align-items-center'>
                        <div class='col-9'>
                            <input type='text' name='message' class='form-control' id='message'>
                        </div>
                        <div class='col'>
                            <button class='btn btn-primary w-100' type='submit' value='Send'>Send</button>
                        </div>
                        <input type='hidden' value='". $_GET['username'] ."' name='receiver'>
                    </div>
                </form>
            </div>
        </div>

    
    ";

    echo $newSTUFF;
?>


