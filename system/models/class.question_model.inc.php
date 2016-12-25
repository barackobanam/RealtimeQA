<?php

class Question_Model extends Model
{
    /**
    * Loads all questions for a given room
    *
    * @param $room_id int The ID of the room
    * @return array The questions attached to the room
    */
    public function get_room_questions( $room_id )
    {
        $sql = "SELECT
            id AS question_id,
            room_id,
            question,
            is_answered,
            vote_count
            FROM questions
            LEFT JOIN question_votes
            ON( questions.id = question_votes.question_id )
            WHERE room_id = :room_id
            ORDER BY is_answered, vote_count DESC";
        $stmt = self::$db->prepare($sql);
        $stmt->bindParam(':room_id', $room_id, PDO::PARAM_INT);
        $stmt->execute();
        $questions = $stmt->fetchAll(PDO::FETCH_OBJ);
        $stmt->closeCursor();
        return $questions;
    }
    
    /**
* Stores a new question with all the proper associations
*
* @param $room_id int The ID of the room
* @param $question string The question text
* @return array The IDs of the room and the question
*/
    public function create_question( $room_id, $question )
    {
        // Stores the new question in the database
        $sql = "INSERT INTO questions (room_id, question) VALUES (:room_id, :question)";
        $stmt = self::$db->prepare($sql);
        $stmt->bindParam(':room_id', $room_id);
        $stmt->bindParam(':question', $question);
        $stmt->execute();
        $stmt->closeCursor();
        // Stores the ID of the new question
        $question_id = self::$db->lastInsertId();
        /*
        * Because creating a question counts as its first vote, this adds a
        * vote for the question to the database
        */
        $sql = "INSERT INTO question_votes VALUES (:question_id, 1)";
        $stmt = self::$db->prepare($sql);
        $stmt->bindParam(":question_id", $question_id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
        return array(
            'room_id' => $room_id,
            'question_id' => $question_id,
        );
    }
/**
* Increases the vote count of a given question
*
* @param $room_id int The ID of the room
* @param $question_id int The ID of the question
* @return array The IDs of the room and the question
*/
    public function vote_question( $room_id, $question_id )
    {
        // Increments the vote count for the question
        $sql = "UPDATE question_votes
        SET vote_count = vote_count+1
        WHERE question_id = :question_id";
        $stmt = self::$db->prepare($sql);
        $stmt->bindParam(':question_id', $question_id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
        return array(
            'room_id' => $room_id,
            'question_id' => $question_id,
        );
    }
    /**
* Marks a given question as answered
*
* @param $room_id int The ID of the room
* @param $question_id int The ID of the question
* @return array The IDs of the room and question
*/
public function answer_question( $room_id, $question_id )
{
    $sql = "UPDATE questions
    SET is_answered = 1
    WHERE id = :question_id";
    $stmt = self::$db->prepare($sql);
    $stmt->bindParam(':question_id', $question_id, PDO::PARAM_INT);
    $stmt->execute();
    $stmt->closeCursor();
    return array(
    'room_id' => $room_id,
    'question_id' => $question_id,
    );
}
}