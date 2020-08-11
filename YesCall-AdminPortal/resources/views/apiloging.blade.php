<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<form action="{{ url('api/login') }}" method="post">
<input type="text" name="email">
<input type="password" name="password">
    <input type="submit">
</form>
</body>
</html>