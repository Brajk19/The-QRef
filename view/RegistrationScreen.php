<?php

    namespace view;

    class RegistrationScreen extends PageTemplate{
        private function showErrors(){
            if(isset($_SESSION["errorMessage"])){
                foreach ($_SESSION["errorMessage"] as $error){
                    echo create_element("p", true, ["style" => "color:red", "contents" => $error]);
                }

                unset($_SESSION["errorMessage"]);
            }
        }

        protected function generateBody() {
            start_form($this->router->getRoute("VerifyRegistration"), "POST");

            create_table([]);
            $cell1 = create_table_cell(["contents" => create_element("label", true, ["contents" => "First name: "])]);
            $cell2 = create_table_cell(["contents" => create_element("input", true, ["name" => "firstName", "type" => "text", "placeholder" => "First name"])]);
            echo create_table_row(["contents" => [$cell1, $cell2]]);


            $cell1 = create_table_cell(["contents" => create_element("label", true, ["contents" => "Last name: "])]);
            $cell2 = create_table_cell(["contents" => create_element("input", true, ["name" => "lastName", "type" => "text", "placeholder" => "Last name"])]);
            echo create_table_row(["contents" => [$cell1, $cell2]]);


            $cell1 = create_table_cell(["contents" => create_element("label", true, ["contents" => "Date of birth: "])]);
            $cell2 = create_table_cell(["contents" => create_element("input", true, ["name" => "dateOfBirth", "type" => "date"])]);
            echo create_table_row(["contents" => [$cell1, $cell2]]);


            $cell1 = create_table_cell(["contents" => create_element("label", true, ["contents" => "E-mail: "])]);
            $cell2 = create_table_cell(["contents" => create_element("input", true, ["name" => "email", "type" => "text", "placeholder" => "E-mail"])]);
            echo create_table_row(["contents" => [$cell1, $cell2]]);


            $cell1 = create_table_cell(["contents" => create_element("label", true, ["contents" => "Password: "])]);
            $cell2 = create_table_cell(["contents" => create_element("input", true, ["name" => "password", "type" => "password", "placeholder" => "Password"])]);
            echo create_table_row(["contents" => [$cell1, $cell2]]);


            $cell1 = create_table_cell(["contents" => create_element("label", true, ["contents" => "Repeat password: "])]);
            $cell2 = create_table_cell(["contents" => create_element("input", true, ["name" => "passwordRepeat", "type" => "password", "placeholder" => "Repeat password"])]);
            echo create_table_row(["contents" => [$cell1, $cell2]]);


            $cell1 = create_table_cell(["contents" => create_element("input", true, ["colspan" => "2", "type" => "submit", "value" => "Register"])]);
            echo create_table_row(["contents" => [$cell1]]);
            end_table();
            end_form();

            $this->showErrors();
        }
    }

?>