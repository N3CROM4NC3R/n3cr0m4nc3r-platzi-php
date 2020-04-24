<?php
    namespace App\Controllers;

    use App\Models\User;
    use App\Controllers\BaseController;
    use Zend\Diactoros\Response\RedirectResponse;


    class AuthController extends BaseController{
        public function getLogin($request){
            return $this->renderHTML('login.twig');
        }
        public function postLogin($request){
            $postData = $request->getParsedBody();
            $responseMessage = [];

            // $userValidator = Validator::key('email', Validator::email())
            //                 ->key('password', Validator::password());
            $user = User::where('email',$postData['email'])->first();

            if($user){
                if(password_verify($postData['password'],$user->password)){
                    $_SESSION['userId'] = $user->id;
                    return new RedirectResponse('/admin');
                }else{
                    $responseMessage = 'Bad credentials';
                }
            }
            else{
                $responseMessage = 'Bad credentials';
            }
            return $this->renderHTML('login.twig',[
                'responseMessage' => $responseMessage
            ]);
        }

        public function getLogout($request){
            unset($_SESSION['userId']);
            return new RedirectResponse('/login');
        }
    }

?>
