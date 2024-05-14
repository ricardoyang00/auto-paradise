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

    public static function getNotificationById(PDO $db, $notificationId) : ?Notification{
        $stmt = $db->prepare('SELECT * FROM NOTIFICATION WHERE notification_id = ? LIMIT 1');
        $stmt->execute([$notificationId]);

        $notification = $stmt->fetch();
        if ($notification) {
            $title = '';
            $message = '';
            $is_read = $notification['is_read'] ? 1 : 0;

            switch ($notification['type']) {
                case 'Sold':
                    $title = 'Congratulations! Your product has been sold!';
                    $message = 'Check in your profile on the sold products section for more details.';
                    break;
                case 'Question':
                    $title = 'You have a new question!';
                    $message = 'Someone is interested in your product. Reply to the question as soon as possible.';
                    break;
                case 'Product-banned':
                    $title = 'Your product has been banned :(';
                    $message = 'Unfortunately, your product has been banned due to a violation of our terms and conditions. Please check the reason.';
                    break;
                case 'Reply':
                    $title = 'You have a new reply!';
                    $message = 'The seller has replied to your question. Check it out!';
                    break;
                case 'Ban':
                    $title = 'Your product has been banned :(';
                    $productID = $notification['extra_info'];
                    $message = 'Unfortunately, your product has been banned due to a violation of our terms and conditions. Check the reason in your profile.';
                    break;
                case 'Unban':
                    $title = 'Your product has been unbanned!';
                    $productID = $notification['extra_info'];
                    $message = 'Your product has been unbanned. You can now sell it again. Check in your profile for more details.';
                    break;
                default:
                    return null;
            }

            return new Notification(
                $notification['notification_id'],
                $notification['username'],
                $title,
                $message,
                (new DateTime($notification['date']))->modify('+1 hour'),
                $is_read,
                $notification['type'],
                $notification['extra_info']
            );
        }
        
        return null;
    }

    public static function getUserNotifications(PDO $db, $userId) : array {
        $stmt = $db->prepare('SELECT notification_id FROM NOTIFICATION WHERE username = ? ORDER BY is_read ASC, date DESC');
        $stmt->execute([$userId]);

        $notifications = array();
        while ($notificationIDs = $stmt->fetch()) {
            $notification = self::getNotificationById($db, $notificationIDs['notification_id']);
            if ($notification) {
                $notifications[] = $notification;
            }
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

    public static function deleteNotification(PDO $db, $notificationId) {
        $stmt = $db->prepare('DELETE FROM NOTIFICATION WHERE notification_id = ?');
        $stmt->execute([$notificationId]);
    }
}

?>