<?php

    require_once('vendor/autoload.php');
    require_once('app/Models/Job.php');
    require_once('app/Models/Project.php');

    use app\Models\Job;
    use app\Models\Project;
    use app\Models\Printable;


    // //Jobs
    // //----------------------------------------------------------------
    // $job1 = new Job('PHP Developer', 'This is an awesome job!!!');
    // $job1->setVisible(true);
    // $job1->setMonths(16);
    //
    // $job2 = new Job('Python Dev', 'This is most best awesome job!!!');
    // $job2->setVisible(true);
    // $job2->setMonths(24);
    //
    // $job3 = new Job('Devops', 'This is an awesome job!!!');
    // $job3->setVisible(true);
    // $job3->setMonths(32);
    //
    // $jobs = [
    //     $job1,
    //     $job2,
    //     $job3,
    // ];

    $jobs = Job::all();

    function printElement(Printable $job){
        if($job->getVisible() == false){
            return;
        }
        echo"<li class='work-position'>";
        echo"<h5>" . $job->title ."</h5>";
        echo"<p>" . $job->description . "</p>";
        echo"<p> Duration: ".$job->months . "</p>";
        echo"<strong>Achievements:</strong>";
        echo"<ul>";
        echo"<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>";
        echo"<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>";
        echo"<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>";
        echo"</ul>";
        echo"</li>";

    }


    // $project1 = new Project("Project 1" , "Description 1",['PHP','CSS','HTML']);
    //
    // $projects = [
    //     $project1
    // ]

?>
