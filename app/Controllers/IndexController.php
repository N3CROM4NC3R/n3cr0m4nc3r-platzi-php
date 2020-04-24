<?php
    namespace App\Controllers;

    use App\Controllers\BaseController;
    use App\Models\Job;
    

    class IndexController extends BaseController {
        private $template_name = 'index.twig';


        public function indexAction(){

            $jobs = Job::all();
            $name = "Santiago Padron";
            $limitMonths = 2000;

            $contextData = [
                "jobs"=>$jobs,
                "name" =>$name,
            ];

            return $this->renderHTML($this->template_name, $contextData);

        }
    }
?>
