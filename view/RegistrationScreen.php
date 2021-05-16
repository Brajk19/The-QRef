<?php

    namespace view;

    use utility\Resource;

    class RegistrationScreen extends PageTemplate{
        private function resetSavedInfo(): void{
            if(isset($_SESSION["savedFirstName"])) unset($_SESSION["savedFirstName"]);
            if(isset($_SESSION["savedLastName"])) unset($_SESSION["savedLastName"]);
            if(isset($_SESSION["savedDateOfBirth"])) unset($_SESSION["savedDateOfBirth"]);
            if(isset($_SESSION["savedEmail"])) unset($_SESSION["savedEmail"]);
        }

        private function showErrors(): void{
            if(isset($_SESSION["errorMessage"])){
                foreach ($_SESSION["errorMessage"] as $error){
                    echo create_element("p", true, ["style" => "color:red; text-align:center", "contents" => $error]);
                }

                unset($_SESSION["errorMessage"]);
            }
        }

        protected function generateBody():void {
            echo create_element("br", false, []);
            echo create_element("h1", true, ["contents" => "Registration", "style" => "text-align:center"]);
            start_form($this->router->getRoute("VerifyRegistration"), "POST");
            $firstName = isset($_SESSION["savedFirstName"]) ? $_SESSION["savedFirstName"] : "";
            $lastName = isset($_SESSION["savedLastName"]) ? $_SESSION["savedLastName"] : "";
            $dateOfBirth = isset($_SESSION["savedDateOfBirth"]) ? $_SESSION["savedDateOfBirth"] : "";
            $email = isset($_SESSION["savedEmail"]) ? $_SESSION["savedEmail"] : "";

            create_table(["style" => "margin:auto"]);
            $cell1 = create_table_cell(["contents" => create_element("label", true, ["contents" => "First name: "])]);
            $cell2 = create_table_cell(["contents" => create_element("input", true, ["name" => "firstName", "type" => "text",
                                                                                "placeholder" => "First name", "value" => $firstName])]);
            echo create_table_row(["contents" => [$cell1, $cell2]]);


            $cell1 = create_table_cell(["contents" => create_element("label", true, ["contents" => "Last name: "])]);
            $cell2 = create_table_cell(["contents" => create_element("input", true, ["name" => "lastName", "type" => "text",
                                                                                "placeholder" => "Last name", "value" => $lastName])]);
            echo create_table_row(["contents" => [$cell1, $cell2]]);


            $cell1 = create_table_cell(["contents" => create_element("label", true, ["contents" => "Date of birth: "])]);
            $cell2 = create_table_cell(["contents" => create_element("input", true, ["name" => "dateOfBirth", "type" => "date",
                                                                                "value" => $dateOfBirth])]);
            echo create_table_row(["contents" => [$cell1, $cell2]]);


            $cell1 = create_table_cell(["contents" => create_element("label", true, ["contents" => "E-mail: "])]);
            $cell2 = create_table_cell(["contents" => create_element("input", true, ["name" => "email", "type" => "text",
                                                                                "placeholder" => "E-mail", "value" => $email])]);
            echo create_table_row(["contents" => [$cell1, $cell2]]);


            $cell1 = create_table_cell(["contents" => create_element("label", true, ["contents" => "Password: "])]);
            $cell2 = create_table_cell(["contents" => create_element("input", true, ["name" => "password", "type" => "password", "placeholder" => "Password"])]);
            echo create_table_row(["contents" => [$cell1, $cell2]]);


            $cell1 = create_table_cell(["contents" => create_element("label", true, ["contents" => "Repeat password: "])]);
            $cell2 = create_table_cell(["contents" => create_element("input", true, ["name" => "passwordRepeat", "type" => "password", "placeholder" => "Repeat password"])]);
            echo create_table_row(["contents" => [$cell1, $cell2]]);

            end_table();

            echo Resource::getAvatarsHTML();
            echo create_element("input", true, ["colspan" => "2", "type" => "submit", "value" => "Register",
                "style" => "margin-left:41%"]);
            echo create_element("br", false, []);
            echo create_element("br", false, []);

            end_form();

            start_form($this->router->getRoute("Login"), "POST");
            echo create_element("input", true, ["colspan" => "2", "type" => "submit", "value" => "Return",
                "style" => "margin-left:41%"]);
            end_form();

            $this->showErrors();
            $this->resetSavedInfo();
        }
    }

?>