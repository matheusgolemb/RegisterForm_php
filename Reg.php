<?php
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $empPos = $_POST['empPos'];
        $empDep = $_POST['empDep'];
        $salary = round($_POST['salary'],2);
        $mStatus = $_POST['mStatus'];
        $fullName = $fname." ".$lname;
        // Setting the final salary if employee is maried. Add 10% to salary.
        if($mStatus=='Married'){
            $finalSal = round($salary + ($salary * 0.1),2);
        }else{
            $finalSal = $salary;
        }
        $empInfo = [
            'fname'=>$fname,
            'lname'=>$lname,
            'fullName'=>$fullName,
            'empPos'=>$empPos,
            'empDep'=>$empDep,
            'salary'=>$salary,
            'mStatus'=>$mStatus,
            'final_sal'=>$finalSal
        ];
        print_r($empInfo);
        if(file_exists('./data/EmpData.txt')){ //checking in file exists
            $empFile = fopen('./data/EmpData.txt', 'r'); //open file
            $strData = fread($empFile, filesize('./data/EmpData.txt')); //read file and on 2nd param. is to find the filesize so that everything is read
            fclose($empFile);
            $employees = json_decode($strData, true); //decoding to associate array format from JSON format(written in .txt)
            array_push($employees, $empInfo); //Adding the newInfo to the existent file(now its inside employees array)
            $empFile = fopen('./data/EmpData.txt', 'w'); //open to write
            fwrite($empFile, json_encode($employees)); //writing in the file in json format
            fclose($empFile);
        }else{
            $employees = []; //create empty array
            array_push($employees, $empInfo); //add array with the information from html to employee array
            $empFile = fopen('./data/EmpData.txt', 'w');
            fwrite($empFile, json_encode($employees));
            fclose($empFile);
        }
        echo "<br/>";
        echo "<h3>Information added to database with success!</h3>";
    }
?>