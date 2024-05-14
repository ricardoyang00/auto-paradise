<?php

declare(strict_types = 1);

class Questions {
    public int $id;
    public string $sender;
    public string $question;
    public ?string $answer;
    public int $productId;

    public function __construct($id, $sender, $question, $answer, $productId) {
        $this->id = $id;
        $this->sender = $sender;
        $this->question = $question;
        $this->answer = $answer;
        $this->productId = $productId;
    }

    public static function getProductQuestions(PDO $db, $productId) {
        $stmt = $db->prepare('SELECT * FROM QA WHERE product_id = ?');
        $stmt->execute([$productId]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $questions = [];
        foreach ($results as $result) {
            $questions[] = new Questions(
                $result['qa_id'],
                $result['user_id'],
                $result['question'],
                $result['answer'],
                $result['product_id']
            );
        }
        return $questions;
    }

    public static function askQuestion(PDO $db, $productId, $sender, $question) {
        $stmt = $db->prepare('INSERT INTO QA (user_id, question, product_id) VALUES (?, ?, ?)');
        $stmt->execute([$sender, $question, $productId]);
        
        $qaId = $db->lastInsertId();
        
        return $qaId;
    }

    public static function answerQuestion(PDO $db, $answer, $questionId) {
        $stmt = $db->prepare('UPDATE QA SET answer = ? WHERE qa_id = ?');
        $stmt->execute([$answer, $questionId]);
    }

    public static function getQuestionById(PDO $db, $questionId) : ?Questions {
        $stmt = $db->prepare('SELECT * FROM QA WHERE qa_id = ?');
        $stmt->execute([$questionId]);

        $result = $stmt->fetch();
        if ($result) {
            return new Questions(
                $result['qa_id'],
                $result['user_id'],
                $result['question'],
                $result['answer'],
                $result['product_id']
            );
        }

        return null;
    }

    public static function deleteQuestion(PDO $db, $questionId) {
        $stmt = $db->prepare('DELETE FROM QA WHERE qa_id = ?');
        $stmt->execute([$questionId]);
    }
}

?>