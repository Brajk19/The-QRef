<?php

    namespace view;

    use exception\QuizCreateSuccessException;
    use router\Router;

    class CreateQuiz extends MainPage {
        private string $name = "";
        private string $description = "";
        private string $qref = "";
        private ?\Exception $e = NULL;

        public function __construct(\Exception $e = NULL) {
            parent::__construct();

            if(isset($_SESSION["quizName"])){
                $this->name = $_SESSION["quizName"];
                unset($_SESSION["quizName"]);
            }
            if(isset($_SESSION["description"])) {
                $this->description = $_SESSION["description"];
                unset($_SESSION["description"]);
            }
            if(isset($_SESSION["qref"])) {
                $this->qref = $_SESSION["qref"];
                unset($_SESSION["qref"]);
            }

            if(!is_null($e)){
                $this->e = $e;
            }
        }

        private function errorMessage(): void{
            if(!is_null($this->e)) {
                $class = $this->e instanceof QuizCreateSuccessException ? "quizCreateSuccess" : "quizCreateError";

                echo create_element("p", true, ["contents" => $this->e->getMessage(),
                    "class" => $class]);
            }
        }

        protected function generateBody():void {
            parent::generateBody();
            $this->errorMessage();

            $div1 = create_element("div", false, []);
            add_to_element($div1, create_element("h2", true, ["contents" => "Instructions:"]));
            add_to_element($div1, create_element("p", true, ["contents" => "After selecting name and quiz
                description, attach .qref file with questions or write them in text area below while following the rules of .qref format."]));

            $dl = create_element("dl", false, []);
            add_to_element($dl, create_element("dt", true, ["contents" => "There are 3 types of questions:"]));
            add_to_element($dl, create_element("dd", true, ["contents" => "1 - question with only one correct answer"]));
            add_to_element($dl, create_element("dd", true, ["contents" => "2 - question with multiple possible correct answers (min: 1, max: 4)"]));
            add_to_element($dl, create_element("dd", true, ["contents" => "3 - question with text answer"]));
            close_element($dl);
            add_to_element($div1, $dl);

            $dl = create_element("dl", false, []);
            add_to_element($dl, create_element("dt", true, ["contents" => "Valid format for each type of question:"]));
            add_to_element($dl, create_element("dd", true, ["contents" => "question text{1}: 1st option, 2nd, 3rd, 4th, correct answer;"]));
            add_to_element($dl, create_element("dd", true, ["contents" => "question text{2}: 1st option, 2nd, 3rd, 4th, correct answer, correct answer,...;"]));
            add_to_element($dl, create_element("dd", true, ["contents" => "question text{3}: correct answer;"]));
            close_element($dl);
            add_to_element($div1, $dl);

            $dl = create_element("dl", false, []);
            add_to_element($dl, create_element("dt", true, ["contents" => "Examples:"]));
            add_to_element($dl, create_element("dd", true, ["contents" => "2 + 3 = _{1}: 4, 6, 5, 3, 5;"]));
            add_to_element($dl, create_element("dd", true, ["contents" => "Choose prime numbers.{2}: 5, 6, 7, 8, 5, 7;"]));
            add_to_element($dl, create_element("dd", true, ["contents" => "Who was the first emperor of Rome?{3}: Augustus;"]));
            close_element($dl);

            add_to_element($div1, $dl);
            close_element($div1);

            $form = create_element("form", false, ["action" => Router::getInstance()->getRoute("VerifyQuiz"),
                "method" => "POST", "enctype" => "multipart/form-data", "id" => "quiz", "style" => "font-size:15px"]);
            add_to_element($form, create_element("br", false, []));
            add_to_element($form, create_element("input", true, ["type" => "text", "name" => "quizName",
                "placeholder" => "Quiz name", "size" => "100", "value" => $this->name]));
            add_to_element($form, create_element("br", false, []));
            add_to_element($form, create_element("br", false, []));
            add_to_element($form, create_element("input", true, ["type" => "text", "name" => "quizDescription",
                "placeholder" => "Quiz description", "size" => "100", "value" => $this->description]));
            add_to_element($form, create_element("br", false, []));
            add_to_element($form, create_element("br", false, []));
            add_to_element($form, create_element("input", true, ["type" => "file", "name" => "qrefFile"]));
            add_to_element($form, create_element("br", false, []));
            add_to_element($form, create_element("br", false, []));
            add_to_element($form, create_element("textarea", true, ["name" => "qrefText",
                "placeholder" => "Write your questions here if you did not upload them above. Everything that's written here will be ignored if file is uploaded",
                "cols" => "100", "rows" => "10", "contents" => $this->qref, "style" => "font-size:15px"]));
            add_to_element($form, create_element("br", false, []));
            add_to_element($form, create_element("label", true, ["contents" => "Out of ideas for question?<br>You can get
                random question for your quiz here. "]));
            add_to_element($form, create_element("input", true, ["type" => "submit", "name" => "action",
                "value" => "Add random question"]));
            add_to_element($form, create_element("br", false, []));
            add_to_element($form, create_element("br", false, []));
            add_to_element($form, create_element("input", true, ["type" => "submit", "value" => "Submit",
                "name" => "action"]));
            close_element($form);

            $div3 = create_element("div", false, []);
            add_to_element($div3, create_element("br", false, []));
            add_to_element($div3, create_element("br", false, []));
            add_to_element($div3, create_element("br", false, []));
            add_to_element($div3, create_element("input", true, ["type" => "checkbox", "form" => "quiz",
                "name" => "public"]));
            add_to_element($div3, create_element("label", true, ["contents" => "public"]));
            add_to_element($div3, create_element("br", false, []));
            add_to_element($div3, create_element("input", true, ["type" => "checkbox", "form" => "quiz",
                "name" => "enableComments"]));
            add_to_element($div3, create_element("label", true, ["contents" => "enable comments"]));
            close_element($div3);

            $grid = create_element("div", false, ["class" => "createQuiz"]);
            add_to_element($grid, $div1);
            add_to_element($grid, $form);
            add_to_element($grid, $div3);
            close_element($grid);

            echo $grid;
        }
    }

?>