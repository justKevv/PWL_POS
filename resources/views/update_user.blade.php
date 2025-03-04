<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Form Update User Data</h1>
    <a href="/user">Back</a>
    <br><br>

    <form method="post" action="/user/update/{{ $user->id_user }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <label>Username</label>
        <input type="text" name="username" placeholder="Enter Username" value="{{ $user->username }}">
        <br>

        <label>Name</label>
        <input type="text" name="name" placeholder="Enter Name" value="{{ $user->name }}">
        <br>

        <label>Password</label>
        <input type="password" name="password" placeholder="Enter Password" value="{{ $user->password }}">
        <br>

        <label>Level ID</label>
        <input type="number" name="id_level" placeholder="Enter Level ID" value="{{ $user->id_level }}">
        <br><br>

        <input type="submit" class="btn btn-success" value="Update">
    </form>
</body>
</html>
