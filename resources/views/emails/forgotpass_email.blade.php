<!DOCTYPE html>
<html>
<head>
    <title>ClearHealth</title>
</head>
<body>
    <h1>{{ $details['title'] }}</h1>
    <p>
    	<a href="{{ url('/reset-password/') }}/{{$details['token']}}" target="_blank">
    		<button>Click Here</button>
    	</a>
    </p>
   
    <p>Thank you</p>
</body>
</html>