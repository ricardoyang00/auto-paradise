<?php
declare(strict_types = 1);

class Notification {
    public int $id;
    public string $userId;
    public string $title;
    public string $message;
    public DateTime $date;
    public int $isRead;
    public string $type;
    public ?int $extra_id;

    // type can be ('Sold', 'Question', 'Product-banned')
    // extra_id is the ID of the product in case of 'Sold' or 'Product-banned' or question ID in case of 'Question' type
    public function __construct($id, $userId, $title, $message, $date, $isRead, $type, $extra_id = null) {
        $this->id = $id;
        $this->userId = $userId;
        $this->title = $title;
        $this->message = $message;
        $this->date = $date;
        $this->isRead = $isRead;
        $this->type = $type;
        $this->extra_id = $extra_id;
    }

    public static function getUserNotifications(PDO $db, $userId) : array {
        $stmt = $db->prepare('SELECT * FROM NOTIFICATION WHERE username = ? ORDER BY is_read ASC, date DESC');
        $stmt->execute([$userId]);

        $notifications = array();
        while ($notification = $stmt->fetch()) {
            $title = '';
            $message = '';
            $is_read = $notification['is_read'] ? 1 : 0;
            if ($notification['type'] === 'Sold') {
                $title = 'Congratulations! Your product has been sold!';
                $message = 'Check in your profile on the sold products section for more details.';
            } else if ($notification['type'] === 'Question') {
                $title = 'You have a new question!';
                $message = 'Someone is interested in your product. Reply to the question as soon as possible.';
            } else if ($notification['type'] === 'Product-banned') {
                $title = 'Your product has been banned :(';
                $message = 'Unfortunately, your product has been banned due to a violation of our terms and conditions. Please check the reason.';
            } else {
                continue;
            }

            $notifications[] = new Notification(
                $notification['notification_id'],
                $notification['username'],
                $title,
                $message,
                new DateTime($notification['date']),
                $is_read,
                $notification['type'],
                $notification['extra_info']
            );
        }

        return $notifications;
    }

    public static function markAsReaded(PDO $db, $notificationId) {
        $stmt = $db->prepare('UPDATE NOTIFICATION SET is_read = TRUE WHERE notification_id = ?');
        $stmt->execute([$notificationId]);
    }

    public static function markAsUnreaded(PDO $db, $notificationId) {
        $stmt = $db->prepare('UPDATE NOTIFICATION SET is_read = FALSE WHERE notification_id = ?');
        $stmt->execute([$notificationId]);
    }

    public static function getUnreadNotificationsUser(PDO $db, $userId) : int {
        $stmt = $db->prepare('SELECT COUNT(*) FROM NOTIFICATION WHERE username = ? AND is_read = FALSE');
        $stmt->execute([$userId]);

        return $stmt->fetchColumn() ?? 0;
    }

    public static function addNotification(PDO $db, $userId, $type, $extra_id = null) {
        $stmt = $db->prepare('INSERT INTO NOTIFICATION (username, type, extra_info) VALUES (?, ?, ?)');
        $stmt->execute([$userId, $type, $extra_id]);
    }
}

?>