<?php
namespace App\SalaryCalculator;
use App\Clickup\Timer;
use App\Entity\User;
use App\Repository\SalaryRepository;
use App\Repository\UserRepository;
use App\Entity\Salary;
class SalaryCalculator
{
    public function CalculateSalary()
    {
        $user = new UserRepository();
        $salary = new Salary();
        $lastday = date("Y-m-d", strtotime("last day of this month"));
        $timer = new Timer();
        if($lastday == date("Y-m-d")){
            $data = $timer->getTimesByUserAndDay(new \DateTime());
            $aux = date("Y-m-d" , strtotime($data[0]["start_date"]));
            $userFlag = $data[0]["user_email"];
            foreach($data as $item){
                if(strcmp($userFlag , $item["user_email"]) == 0){
                    // hoursUser is a flag to know if the user is changed in this case 
                }else{
                    $hoursUser = 0;
                    $userFlag = $item["user_email"];
                }
                if(date("Y-m-d" ,strtotime($aux)) != date("Y-m-d",strtotime($item["end_date"]))){
                    //$hoursUser represents the  hours worked by the user in the day so if the day changes or the user changes the hours worked will be reset
                    $hoursUser = 0;
                    $aux = date("Y-m-d" , strtotime($item["start_date"]));
                    $hoursUser += ceil(strtotime($item['end_date'])/3600 - strtotime($item['start_date'])/3600);

                    //Flag to know if the day has passed or not
                }else{                    
                    //Flag to know if the day has passed or not
                    $hoursUser += ceil(strtotime($item['end_date'])/3600 - strtotime($item['start_date'])/3600);
                }
                $worker = $user->findWorkerByEmail($item['user_email']);
                if($hoursUser > $worker->hoursPerDay){
                    $salary->overtimeHours = $hoursUser - $worker->hoursPerDay;
                    $salary->salary = $worker->monthlySalary + $salary->overtimeHours * $worker->overtimeSalaryPerHour;
                    $salary->user = $worker;
                    $salary->month = date("Y-m" , strtotime($item["start_date"]));
                    $salaryRepository = new SalaryRepository();
                    $salaryRepository->save($salary);
                
        }else{
            $salary->overtimeHours = 0;
            $salary->salary = $worker->monthlySalary;
            $salary->user = $worker;
            $salary->month = date("Y-m" , strtotime($item["start_date"]));
            $salaryRepository = new SalaryRepository();
            $salaryRepository->save($salary);
        }

       }
    }
}}

?>