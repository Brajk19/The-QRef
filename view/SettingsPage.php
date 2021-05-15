<?php

    namespace view;


    use model\Quizzes;
    use model\User;
    use router\Router;

    class SettingsPage extends MainPage {
        protected function generateBody():void {
            parent::generateBody();

            echo create_element("p", true, ["style" => "margin-top:50px"]);

            $grid = create_element("div", false, ["class" => "settingsGrid"]);

            add_to_element($grid, $this->dataTable());
            add_to_element($grid, $this->scoreTable());
            close_element($grid);

            echo $grid;
        }

        private function dataTable(): string {
            $img = create_element("img", true, ["src" => "../resources/changePassword.png", "height" => "40px"]);
            $button = create_element("a", true, ["href" => Router::getInstance()->getRoute("ChangePasswordForm"),
                "contents" => $img]);

            $dateOfBirth = User::getBirthDate($_SESSION["email"]);

            $headerCell = create_element("th", true, ["class" => "cell", "colspan" => "2", "style" => "text-align:center", "contents" => "USER DATA"]);
            $headerRow = create_element("tr", true, ["contents" => $headerCell]);

            $cell11 = create_table_cell(["class" => "cell", "contents" => "Date of birth"]);
            $cell12 = create_table_cell(["class" => "cell", "contents" => date("d. F Y.", strtotime($dateOfBirth))]);

            $cell21 = create_table_cell(["class" => "cell", "contents" => "E-mail"]);
            $cell22 = create_table_cell(["class" => "cell", "contents" => htmlentities($_SESSION["email"])]);

            $cell31 = create_table_cell(["class" => "cell", "contents" => "Change password..."]);
            $cell32 = create_table_cell(["class" => "cell changePassword", "contents" => $button]);

            $row1 = create_table_row(["contents" => [$cell11, $cell12]]);
            $row2 = create_table_row(["contents" => [$cell21, $cell22]]);
            $row3 = create_table_row(["contents" => [$cell31, $cell32]]);

            $table = create_element("table", false, ["style" => "width:fit-content; border-collapse:collapse"]);
            add_to_element($table, $headerRow);
            add_to_element($table, $row1);
            add_to_element($table, $row2);
            add_to_element($table, $row3);
            close_element($table);

            return $table;
        }

        private function fillStatsTable(array $stats): string{
            $str = "";
            foreach ($stats as $quiz){
                $cell1 = create_table_cell(["contents" => $quiz["name"], "style" => "border:2px solid black"]);
                $cell2 = create_table_cell(["contents" => $quiz["attempts"], "style" => "border:2px solid black"]);
                $cell3 = create_table_cell(["contents" => $quiz["avg"], "style" => "border:2px solid black"]);

                $str .= create_table_row(["contents" => [$cell1, $cell2, $cell3]]);
            }

            return $str;
        }

        private function scoreTable(): string{
            $stats = Quizzes::getStats($_SESSION["email"]);

            $h1 = create_element("th", true, ["class" => "cell", "contents" => "Quiz Name"]);
            $h2 = create_element("th", true, ["class" => "cell", "contents" => "Attempts"]);
            $h3 = create_element("th", true, ["class" => "cell", "contents" => "Average score"]);
            $row1 = create_table_row(["contents" => [$h1, $h2, $h3]]);

            $table = create_element("table", false, ["style" => "border-collapse:collapse; text-align:center"]);
            add_to_element($table, $row1);
            add_to_element($table, $this->fillStatsTable($stats));
            close_element($table);

            return $table;
        }

    }

?>