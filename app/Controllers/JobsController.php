<?php
    namespace App\Controllers;


    use Respect\Validation\Validator;
    use App\Controllers\BaseController;
    use App\Models\Job;

    class JobsController extends BaseController{
        private $template_name = 'addJob.twig';

        public function getAddJobAction($request){
            $method = $request->getMethod();
            $responseMessage = [];
            if($method == 'POST'){

                $jobValidator = Validator::key('title', Validator::stringType()->notEmpty())
                                ->key('description', Validator::stringType()->notEmpty())
                                ->key('months', Validator::number());
                try{
                    $postData = $request->getParsedBody();
                    $data = $postData;
                    $files = $request->getUploadedFiles();

                    $jobValidator->assert($data);

                    $logoImage = $files['logo'];

                    if(isset($logoImage)){
                        $fileName = $logoImage->getClientFilename();
                        $logoImage->moveTo("uploads/logo_projects/$fileName");
                        $data['logo'] = $fileName;
                    }

                    $job = new Job($data);

                    $job->save();
                    $responseMessage = ['message'=>'Trabajo guardado'];
                }catch(\Exception $e){

                    $errors = $e->getMessage();

                     $errors = $e->getMessages([
                         'notEmpty' => '{{name}} es un campo obligatorio'
                     ]);

                    $responseMessage = [
                        'errors' => $errors
                    ];
                }
             }

             return $this->renderHTML($this->template_name,$responseMessage);
        }


    }




?>
