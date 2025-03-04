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
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Name</th>
            <th>ID Level</th>
        </tr>
        <tr>
            <td>{{ $user->id_user }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->id_level }}</td>
        </tr>
        {{-- @foreach ($user as $u)
        @endforeach --}}
    </table>
</body>
</html>
