<?php

    namespace view;

    use router\Router;

    class ChangePassword extends MainPage {
        protected function generateBody() {
            parent::generateBody();

            start_form(Router::getInstance()->getRoute("VerifyNewPassword"), "POST", ["class" => "changePasswordForm"]);

            create_table([]);

            $cell1 = create_table_cell(["contents" => create_element("label", true, ["contents" => "Old password: "])]);
            $cell2 = create_table_cell(["contents" => create_element("input", true, ["name" => "oldPassword", "type" => "password",
                "placeholder" => "*****", "size" => "50"])]);
            echo create_table_row(["contents" => [$cell1, $cell2]]);

            $cell1 = create_table_cell(["contents" => create_element("label", true, ["contents" => "New password: "])]);
            $cell2 = create_table_cell(["contents" => create_element("input", true, ["name" => "newPassword", "type" => "password",
                "placeholder" => "*****", "size" => "50"])]);
            echo create_table_row(["contents" => [$cell1, $cell2]]);

            $cell1 = create_table_cell(["contents" => create_element("label", true, ["contents" => "Repeat new password: "])]);
            $cell2 = create_table_cell(["contents" => create_element("input", true, ["name" => "newPasswordRepeat", "type" => "password",
                "placeholder" => "*****", "size" => "50"])]);
            echo create_table_row(["contents" => [$cell1, $cell2]]);

            $cell1 = create_table_cell(["contents" => create_element("input", true, ["type" => "submit", "value" => "Change password",
                "style" => "font-size:20px"]), "colspan" => "2"]);
            echo create_table_row(["contents" => $cell1]);

            end_table();

            end_form();

        }
    }

?>