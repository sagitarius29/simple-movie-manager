<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Video Player</title>
    <script src="//content.jwplatform.com/libraries/0P4vdmeO.js"></script>
    {{--<script>jwplayer.key='IMtAJf5X9E17C1gol8B45QJL5vWOCxYUDyznpA==';</script>--}}
    <style>
        body {
            margin: 0;
            padding: 0;
            background: black;
        }
        #player {
            max-height: 100vh;
        }
    </style>
</head>
<body>
<div id="player">Loading the player...</div>
<script>
  // Setup the player
  {!! $packer !!}

  /*// Listen to an event
  player.on('pause', (event) => {
    alert('Why did my user pause their video instead of watching it?');
  });*/

  // Call the API
  /*const bumpIt = () => {
    const vol = player.getVolume();
    player.setVolume(vol + 10);
  }
  bumpIt();*/
</script>
</body>
</html>
