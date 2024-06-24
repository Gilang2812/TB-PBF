<!DOCTYPE html>
<html>
<head>
    <title>Overdue Book Reminder</title>
</head>
<body>
    <h1>Overdue Book Reminder</h1>
    <p>Dear User,</p>
    <p>This is a reminder that you have a book that was due on {{ $dueDate->toFormattedDateString() }}. Please return it as soon as possible.</p>
    <p>Thank you!</p>
</body>
</html>
