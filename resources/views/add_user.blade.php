<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Add User Form</h1>
    <form method="post" action="/user/store">
        {{ csrf_field() }}

        <label>Username</label>
        <input type="text" name="username" placeholder="Enter Username">
        <br>

        <label>Name</label>
        <input type="text" name="name" placeholder="Enter Name">
        <br>

        <label>Password</label>
        <input type="password" name="password" placeholder="Enter Password">
        <br>

        <label>Level ID</label>
        <input type="number" name="id_level" placeholder="Enter Level ID">
        <br><br>

        <input type="submit" class="btn btn-success" value="Save">
    </form>
</body>
</html>
