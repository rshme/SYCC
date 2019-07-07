<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=`, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>Document</title>
</head>
<body>
     @foreach (\App\Game::orderBy('name', 'asc')->get() as $data)
          <h1>{{ $data->name }}</h1>
          @foreach ($data->account as $item)
               <h3>{{ $item->username }}</h3>
          @endforeach
     @endforeach
</body>
</html>