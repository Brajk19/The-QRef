<?php

    namespace view;

    class Stats extends MainPage {

        private function tableHeader(): string{
            $h1 = create_element("th", true, ["contents" => "Quiz name", "style" => "padding:15px; border: 2px solid black"]);
            $h2 = create_element("th", true, ["contents" => "Minimum score", "style" => "padding:15px; border: 2px solid black"]);
            $h3 = create_element("th", true, ["contents" => "Maximum score", "style" => "padding:15px; border: 2px solid black"]);
            $h4 = create_element("th", true, ["contents" => "Average score", "style" => "padding:15px; border: 2px solid black"]);
            $h5 = create_element("th", true, ["contents" => "Standard deviation", "style" => "padding:15px; border: 2px solid black"]);
            $h6 = create_element("th", true, ["contents" => "Median", "style" => "padding:15px; border: 2px solid black"]);

            return create_table_row(["contents" => [$h1, $h2, $h3, $h4, $h5, $h6]]);
        }

        private function tableRow($quizStats): string {
            $c1 = create_table_cell(["contents" => $quizStats["name"], "style" => "border:2px solid black"]);
            $c2 = create_table_cell(["contents" => $quizStats["min"], "style" => "border:2px solid black"]);
            $c3 = create_table_cell(["contents" => $quizStats["max"], "style" => "border:2px solid black"]);
            $c4 = create_table_cell(["contents" => floatval($quizStats["avg"]), "style" => "border:2px solid black"]);
            $c5 = create_table_cell(["contents" => floatval($quizStats["stddev"]), "style" => "border:2px solid black"]);
            $c6 = create_table_cell(["contents" => floatval($quizStats["median"]), "style" => "border:2px solid black"]);

            return create_table_row(["contents" => [$c1, $c2, $c3, $c4, $c5, $c6]]);
        }


        private function statsMyQuizzes(): void{
            $stats = \model\Stats::getQuizStats(true);

            create_table(["class" => "quizTable"]);
            echo $this->tableHeader();

            foreach ($stats as $s){
                echo $this->tableRow($s);
            }

            end_table();
        }

        private function statsOtherQuizzes(): void{
            $stats = \model\Stats::getQuizStats(false);

            create_table(["class" => "quizTable"]);
            echo $this->tableHeader();

            foreach ($stats as $s){
                echo $this->tableRow($s);
            }

            end_table();
        }

        protected function generateBody(): void{
            parent::generateBody();
            echo create_element("br", false, []);

            echo create_element("h1", true, ["contents" => "MY QUIZZES", "style" => "text-align:center"]);
            $this->statsMyQuizzes();

            echo create_element("br", false, []);
            echo create_element("br", false, []);

            echo create_element("h1", true, ["contents" => "OTHER QUIZZES", "style" => "text-align:center"]);
            $this->statsOtherQuizzes();
        }

    }

?>