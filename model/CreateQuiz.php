<?php

    namespace model;

    class CreateQuiz {


        /**
         * @param string $name
         * @param string $description
         * @param string $public
         * @param string $comments
         * @param string $qref
         * Stores quiz in database.
         */
        public static function storeQuiz(string $name, string $description, string $public, string $comments, string $qref): void{
            $db = Database::getInstance();

            //ID is not needed because it's auto incremented in database
            $query = <<<SQL
                INSERT INTO quiz
                VALUES(NULL, :email, :name, :description, :public, :comments, :qref)
            SQL;

            $data = $db->prepare($query);
            $data->execute([":email" => $_SESSION["email"], ":name" => $name, ":description" => $description,
                ":public" => $public, ":comments" => $comments, ":qref" => $qref]);
        }

        /**
         * @param string $quizID
         * @param string $name
         * @param string $description
         * @param string $public
         * @param string $comments
         * @param string $qref
         * Applies changes made to quiz and stores them in database.
         */
        public static function updateQuiz(string $quizID, string $name, string $description, string $public,
                                            string $comments, string $qref): void{

            $db = Database::getInstance();

            $query = <<<SQL
                UPDATE quiz
                SET quiz.name = :name, quiz.description = :description, quiz.public = :public, quiz.comments = :comments, quiz.qref = :qref
                WHERE quiz.id = :quizID
            SQL;

            $data = $db->prepare($query);
            $data->execute([":quizID" => $quizID, ":name" => $name, ":description" => $description, ":public" => $public,
                ":comments" => $comments, ":qref" => $qref]);
        }
    }


?>