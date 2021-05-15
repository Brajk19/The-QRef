<?php

    namespace model;

    use exception\InvalidQuizIdException;

    class Quizzes {

        /**
         * @param int $id
         * @return array
         * Returns quiz info if given quiz ID exists.
         * Format: [string quizName, string description, bool isPublic, bool commentsEnabled, string qref]
         * Exception is thrown if given ID does not exist
         * @throws InvalidQuizIdException
         */
        public static function getQuiz(int $id): array{
            $db = Database::getInstance();

            $query = <<<SQL
                SELECT quiz.name, quiz.description, quiz.public, quiz.comments, quiz.qref
                FROM quiz
                WHERE quiz.id = :id
            SQL;

            $data = $db->prepare($query);
            $data->execute([":id" => strval($id)]);
            $data = $data->fetchAll();

            if(empty($data)){
                throw new InvalidQuizIdException(strval($id));
            }

            $data = $data[0];
            $public = $data["public"] === "1";
            $comments = $data["comments"] === "1";

            return array($data["name"], $data["description"], $public, $comments, $data["qref"]);
        }

        /**
         * @param int $id
         * @return array
         * Returns an array containing only questions from quiz with given ID.
         */
        public static function getQuestions(int $id): array{
            $db = Database::getInstance();

            $query = <<<SQL
                SELECT quiz.qref
                FROM quiz
                WHERE quiz.id = :id
            SQL;

            $data = $db->prepare($query);
            $data->execute([":id" => strval($id)]);
            $data = $data->fetchAll()[0];

            $questions = explode(";", $data["qref"]);
            array_pop($questions);

            for($i = 0; $i < count($questions); $i++){
                preg_match("~.+{~", $questions[$i], $arr);

                $questions[$i] = substr($arr[0], 0, -1);
                $arr = [];
            }

            return $questions;

        }

        /**
         * @param string $quizID
         * @param string $email
         * @param int $score
         * Stores score from quiz to database.
         */
        public static function storeResult(string $quizID, string $email, int $score): void{
            $db = Database::getInstance();

            $query = <<<SQL
                INSERT INTO result
                VALUES (:quizID, :email, :score)
            SQL;

            $data = $db->prepare($query);
            $data->execute([":quizID" => $quizID, ":email" => $email, ":score" => $score]);
        }

        /**
         * @param string $email
         * @return array
         * Returns number of attempts and average score for each quiz user took.
         * Format: [[name => quiz name, attempts => number of attempts, avg => average score], [], ...]
         */
        public static function getStats(string $email): array{
            $db = Database::getInstance();

            $query = <<<SQL
                SELECT quiz.name, COUNT(*) as attempts, AVG(score) as avg
                FROM quiz JOIN result
                ON result.quizID = quiz.id
                WHERE result.email = :email
                GROUP BY result.quizID
            SQL;

            $data = $db->prepare($query);
            $data->execute([":email" => $email]);

            return $data->fetchAll();
        }

        /**
         * @param string $id
         * @return bool
         * Returns true if commenting is enabled on quiz.
         */
        public static function commentsEnabled(string $id): bool{
            $db = Database::getInstance();

            $query = <<< SQL
                SELECT quiz.comments
                FROM quiz
                WHERE quiz.id = :id
            SQL;

            $data = $db->prepare($query);
            $data->execute([":id" => $id]);
            $data = $data->fetchAll()[0];

            return $data["comments"] === "1";

        }

        /**
         * @param string $quizID
         * @param string $email
         * @param string $comment
         * Stores a comment in database.
         */
        public static function addComment(string $quizID, string $email, string $comment): void{
         $db = Database::getInstance();
         $time = strval(time());

         $query = <<<SQL
            INSERT INTO comment
            VALUES (:quizID, :email, :comment, :time)
         SQL;

         $data = $db->prepare($query);
         $data->execute([":quizID" => $quizID, ":email" => $email, ":comment" => $comment, ":time" => $time]);
        }

        /**
         * @param string $quizID
         * @return array
         * Returns all comments on selected quiz.
         * Format: [[avatar, firstname, lastname, comment], [], [], ...]
         */
        public static function getComments(string $quizID): array{
            $db = Database::getInstance();

            $query = <<< SQL
                SELECT avatar.avatar, user.firstName, user.lastName, comment.comment
                FROM comment NATURAL JOIN user
                    NATURAL JOIN avatar
                WHERE comment.quizID = :quizID
                ORDER BY comment.time DESC
            SQL;

            $data = $db->prepare($query);
            $data->execute([":quizID" => $quizID]);
            $data = $data->fetchAll();

            // _text_ will be underline
            // *text* will be bold
            for ($i = 0; $i < count($data); $i++){
                while(substr_count($data[$i]["comment"], "*") >= 2){
                    $data[$i]["comment"] = preg_replace("~\*~", "<b>", $data[$i]["comment"], 1);
                    $data[$i]["comment"] = preg_replace("~\*~", "</b>", $data[$i]["comment"], 1);
                }
                while(substr_count($data[$i]["comment"], "_") >= 2){
                    $data[$i]["comment"] = preg_replace("~_~", "<u>", $data[$i]["comment"], 1);
                    $data[$i]["comment"] = preg_replace("~_~", "</u>", $data[$i]["comment"], 1);
                }
            }

            return $data;
        }
    }

?>