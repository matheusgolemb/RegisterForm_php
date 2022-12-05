<?php
    if(file_exists('./data/EmpData.txt')){
        $empFile = fopen('./data/EmpData.txt', 'r');
        $strData = fread($empFile, filesize('./data/EmpData.txt'));
        fclose($empFile);
        $employees = json_decode($strData, true);
        // print_r($employees);
        $salaries = []; //array with all salaries, so its easier to calculate the avg
        $aboveAvg = []; //array to store employees with salary above avg
        $sum = 0; //var to sum all salaries
        foreach($employees as $emp){ //loop through each employee inside database(now inside employees var)
            $fullName = $emp['fullName'];
            $salaries[$emp['fname']."_".$emp['lname']] = $emp['final_sal']; //setting the salary of emp. Used key with 'fname_last name' to dont have spaces in the key
            $sum += $emp['final_sal'];
        }
        $avgSal = round($sum/count($salaries),2); //calc the avg salary and rounding to two decimal digits
        foreach($employees as $emp){
            if($emp['final_sal']>$avgSal){
                // array_push($aboveAvg, [$emp['fullName'] => $emp['final_sal']]);
                $aboveAvg[$emp['fullName']]=$emp['final_sal'];
            }
        }
        // print_r($aboveAvg);
        arsort($aboveAvg); //sorting associate array in descending order
        // echo "<br/>";
        // print_r($aboveAvg);
        // print_r("The avg salary is: ".$avgSal);
        // // echo "<br/>";
        // echo "<br/>";
        // print_r($salaries);
        // $avgSal
    }  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container col-10 mt-3 d-grid gap-3">
        <div class="container">
            <a href="./EmpReg.html" class="btn btn-outline-dark p-3">
               Register form
            </a>
        </div>
        <div class="table-responsive">
            <caption>
                <h3 id="titleTable">Employees List</h3>
            </caption>
            <table class="table table-striped
            table-hover	
            table-borderless
            table-primary
            align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Full Name</th>
                    <th>Position</th>
                    <th>Department</th>
                    <th>Base Salary</th>
                    <th>Marriage Status</th>
                    <th>Final Salary</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php
                    if(file_exists('./data/EmpData.txt')){
                        foreach($employees as $idx=>$emp){
                            // I didn't used another foreach inside $emp variable because the td aren't in correct order of the emp data
                            //And there's more keys inside emp than in the td that's being displayed
                            echo "<tr class='table-light'>";
                            echo "<td scope='row'>".$emp['fname']." ".$emp['lname']."</td>";
                            echo "<td>".$emp['empPos']."</td>";
                            echo "<td>".$emp['empDep']."</td>";
                            echo "<td>".$emp['salary']."</td>";
                            echo "<td>".$emp['mStatus']."</td>";
                            echo "<td>".$emp['final_sal']."</td>";
                            echo "</tr>";
                        }
                    }
                ?>
                </tbody>
                <tfoot>
                    <tr class="table-dark">
                        <td colspan='5' style>
                            Total salary of employees:
                        </td>
                        <td>
                            <?php
                                if(file_exists('./data/EmpData.txt')) echo $sum
                            ?>
                        </td>
                    </tr>
                </tfoot>
                </table>
        </div>
        <div class="row d-grid gap-3">
            <div class="row">
                <?php
                 if(file_exists('./data/EmpData.txt')){
                     echo "<h3 class='text-success text-center'>The average salary is: ".$avgSal."</h3>";
                     echo "<h3 class='text-success text-center'>Table of employees with salary above the average:</h3>";
                }
                ?>
            </div>
            <div class="col-4 mx-auto">
                <div class="table-responsive">
                    <table class="table
                    table-hover	
                    table-borderless
                    table-primary
                    align-middle">
                        <thead class="table-success">
                            <tr>
                                <th>Full Name</th>
                                <th>Salary</th>
                            </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <?php
                                if(file_exists('./data/EmpData.txt')){
                                    $aboveSum=0;
                                    foreach($aboveAvg as $name=>$sal){
                                        echo "<tr class='table-light'>";
                                        // foreach($item as $name=>$sal){
                                            $aboveSum += $sal;
                                            echo "<td scope='row'>$name</td><td>$sal</td>";
                                        // }
                                        echo "</tr>";
                                    }
                                }
                                ?>
                            </tbody>
                            <tfoot class="table-success">
                                <tr>
                                    <td>
                                        Total:
                                    </td>
                                    <td>
                                        <?php
                                            if(file_exists('./data/EmpData.txt')) echo $aboveSum;
                                        ?>
                                    </td>
                                </tr>
                            </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;900&display=swap');
    *, body {
        font-family: 'Poppins', sans-serif;
        font-weight: 400;
    }
    html, body{
        background-color: whitesmoke;
    }
    #titleTable{
        color: darkslateblue;

    }
</style>
</html>