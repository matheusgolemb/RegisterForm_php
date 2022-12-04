<?php
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $empPos = $_POST['empPos'];
        $empDep = $_POST['empDep'];
        $salary = $_POST['salary'];
        $mStatus = $_POST['mStatus'];
        $fullName = $fname." ".$lname;
        if($mStatus=='Married'){
            $baseSal = $salary;
            $finalSal = $baseSal + ($baseSal * 0.1);
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
        if(file_exists('./data/EmpData.txt')){
            $empFile = fopen('./data/EmpData.txt', 'r');
            $strData = fread($empFile, filesize('./data/EmpData.txt'));
            fclose($empFile);
            $employees = json_decode($strData, true);
            array_push($employees, $empInfo);
            $empFile = fopen('./data/EmpData.txt', 'w');
            fwrite($empFile, json_encode($employees));
            fclose($empFile);
        }else{
            $employees = [];
            array_push($employees, $empInfo);
            $empFile = fopen('./data/EmpData.txt', 'w');
            fwrite($empFile, json_encode($employees));
            fclose($empFile);
        }
    }
?>