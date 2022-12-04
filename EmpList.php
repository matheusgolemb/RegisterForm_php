<?php
    if(file_exists('./data/EmpData.txt')){
        $empFile = fopen('./data/EmpData.txt', 'r');
        $strData = fread($empFile, filesize('./data/EmpData.txt'));
        fclose($empFile);
        $employees = json_decode($strData, true);
        // print_r($employees);
        $salaries = [];
        $aboveAvg = [];
        $sum = 0;
        foreach($employees as $emp){
            $fullName = $emp['fullName'];
            $salaries[$emp['fname']."_".$emp['lname']] = $emp['final_sal'];
            $sum += $emp['final_sal'];
        }
        $avgSal = $sum/count($salaries);
        foreach($employees as $emp){
            if($emp['final_sal']>$avgSal){
                $fullName = $emp['fullName'];
                // $aboveAvg = $emp;
                $tmp = [
                    'fullName'=>$fullName, 
                    'mStatus'=>$emp['mStatus'], 
                    'final_sal'=>$emp['final_sal']
                ];
                array_push($aboveAvg, $tmp);
            }
        }
        // print_r($employees);
        // echo "<br/>";
        // print_r("The avg salary is: ".$avgSal);
        // echo "<br/>";
        // print_r($aboveAvg);
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
    <div class="container col-10 mt-3 d-grid gap-5">
        <div class="table-responsive">
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
                            echo "<tr class='table-light'>";
                            echo "<td scope='row'>".$emp['fname']." ".$emp['lname']."</td>";
                            echo "<td scope='row'>".$emp['empPos']."</td>";
                            echo "<td scope='row'>".$emp['empDep']."</td>";
                            echo "<td scope='row'>".$emp['salary']."</td>";
                            echo "<td scope='row'>".$emp['mStatus']."</td>";
                            if($emp['mStatus']=='Married'){
                                $baseSal = $emp['salary'];
                                $finalSal = $baseSal + ($baseSal * 0.1);
                                echo "<td scope='row'>".$finalSal."</td>";
                            }else{
                                echo "<td scope='row'>".$emp['salary']."</td>";
                            }
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
                                    foreach($aboveAvg as $key=>$expEmp){
                                        $aboveSum += $expEmp['final_sal'];
                                        echo "<tr class='table-light'>";
                                        echo "<td scope='row'>".$expEmp['fullName']. "</td>";
                                        echo "<td scope='row'>".$expEmp['final_sal']. "</td>";
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
</style>
</html>