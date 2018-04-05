<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <style>
        .advert_title{
            background-color: #B6E469;
            margin-left: 150px;
            height: 70px;
            line-height: 70px;
            border-radius: 8px;
        }
        .advert_title>h3{
            margin-left: 50px;
        }
        .msg{
            background-color: #F2F2F2;
            height: 40px;
            width: 80%;
            border-radius: 8px;
            padding: 10px 20px;
        }
        .name{
            margin-left: 15px;
        }
    </style>
    <body>
        <div class="advert_title"><h3>{{$advert_title}}</h3></div>
        <div class="name">{{$name}}</div>
        <div class="msg"><p>{{$msg}}</p></div>
    </body>
</html>