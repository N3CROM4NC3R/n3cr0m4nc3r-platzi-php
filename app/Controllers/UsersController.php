<?php
    namespace App\Controllers;

    use App\Controllers\BaseController;
    use App\Models\User;

    use Respect\Validation\Validator;


    class UsersController extends BaseController{

        public function getRegisterUserAction($request){
            $method = $request->getMethod();
            $responseMessage = [];
            if($method == 'POST'){
                $userValidator = Validator::key('email', Validator::email())
                                ->key('password', Validator::alnum());

                $dataPost = $request->getParsedBody();

                try{
                    $userValidator->assert($dataPost);
                    $data = $dataPost;
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                    $user = new User($data);
                    $user->save();
                    $responseMessage = [
                        'message' => 'Usuario Registrado con exito'
                    ];
                }
                catch(\Illuminate\Database\QueryException $e){
                    $errors = $e->errorInfo;
                    // var_dump($errors);
                    $responseMessage = [
                        'errorUserRegistered' => $errors
                    ];
                }
                catch(\Exception $e){
                    $errors = $e->getMessages();

                    $responseMessage = [
                        'errors' => $errors
                    ];
                }
            }
            return $this->renderHTML('registerUser.twig', $responseMessage);
        }
    }


?>
