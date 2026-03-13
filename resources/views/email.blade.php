<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $emaildata['subject'] }}</title>
   
</head>
<body>
    <body style="font-family: Arial,verdana ">
       <div>
        <img src="{{ asset(siteInfo()->logo) }}" alt="" width="200">
       </div>
       <hr> 
       <div style="margin: 40px auto; max-width: 60%;">
          <p style="font-size: 15px"> {!! $emaildata['message'] !!}</p> 
       </div>
       
    </body>
</body>
</html> 