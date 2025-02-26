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
            <th>Code Level</th>
            <th>Level Name</th>
        </tr>
        @foreach ($data as $d)
        <tr>
            <td>{{ $d->id_level }}</td>
            <td>{{ $d->code_level }}</td>
            <td>{{ $d->name_level }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
