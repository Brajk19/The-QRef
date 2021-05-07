<?php

    namespace controller;


    use exception\DifferentPasswordException;
    use exception\IncorrectOldPasswordException;
    use exception\IncorrectPasswordFormatException;
    use model\User;
    use view\ChangePassword;
    use view\ChangePasswordError;
    use view\SettingsPage;

    class Settings {

        public function showSettings(): void{
            $s = new SettingsPage();
            $s->generateHTML();
        }

        public function changePasswordForm(): void{
            $cp = new ChangePassword();
            $cp->generateHTML();
        }

        public function verifyNewPassword(): void{
            try{
                if(!User::verifyPassword($_POST["oldPassword"])){
                    throw new IncorrectOldPasswordException();
                }

                if($_POST["newPassword"] !== $_POST["newPasswordRepeat"]){
                    throw new DifferentPasswordException();
                }

                if(!$this->checkPasswordFormat($_POST["newPassword"])){
                    throw new IncorrectPasswordFormatException();
                }

                //succesful password change
                User::changePassword($_POST["newPassword"]);
                echo "radiiiiiiiiiiiii";
            }
            catch(IncorrectOldPasswordException | IncorrectPasswordFormatException | DifferentPasswordException $e){
                $cpe = new ChangePasswordError($e);
                $cpe->generateHTML();
            }
        }


        private function checkPasswordFormat(string $password): bool{
            $regex = "^(?=.*[[:upper:]])(?=.*[[:digit:]])(?=.*[[:lower:]]+)[[:alnum:]\-_]{5,}$";

            if(preg_match("~$regex~", $password)) return true;
            return false;
        }
    }

?>