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
            <th>User Count</th>
        </tr>
        <tr>
            <td>{{ $user}}</td>
        </tr>
        {{-- @foreach ($user as $u)
        @endforeach --}}
    </table>
</body>
</html>
