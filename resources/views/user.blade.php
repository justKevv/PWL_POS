<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>User Level Data</h1>
    <a href="/user/add">+ Add User</a>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Name</th>
            <th>ID Level</th>
            <th>Code Level</th>
            <th>Level Name</th>
            <th>Action</th>
        </tr>
        @foreach ($user as $u)
            <tr>
                <td>{{ $u->id_user }}</td>
                <td>{{ $u->username }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->id_level }}</td>
                <td>{{ $u->level->code_level }}</td>
                <td>{{ $u->level->name_level }}</td>
                <td><a href="/user/edit/{{ $u->id_user }}">Update</a> | <a href="/user/delete/{{ $u->id_user }}">Delete</a>
                </td>
            </tr>
        @endforeach
    </table>
</body>

</html>
