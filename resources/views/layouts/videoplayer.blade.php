<!DOCTYPE html>
<html>
<head>
    <script src="//content.jwplatform.com/libraries/0P4vdmeO.js"></script>
    {{--<script>jwplayer.key='IMtAJf5X9E17C1gol8B45QJL5vWOCxYUDyznpA==';</script>--}}
    <style>
        body {
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
<div id="player">Loading the player...</div>
<script>
  // Setup the player
  const player = jwplayer('player').setup({
    file: '{{ $videoUrl  }}',
    type: 'mp4',
    width: '100%',
    height: '100vh'
  });

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
