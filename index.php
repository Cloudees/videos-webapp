<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="bootstrap.min.css">
  <title>Videos Catalog</title>
</head>

<body>
  <noscript>You need to enable JavaScript to run this app.</noscript>

  <article>
    <nav class="navbar navbar-light bg-light">
      <span class="navbar-brand mb-0 h1">Videos Catalog: "1.0.10"</span>
    </nav>
    <div ng-app="videos" ng-controller="videosController" class="container">
      <div class="row">
        <div id="accordion">

          <div id="{{ l.id }}" ng-repeat="l in playlist" class="card">

            <div class="card-header" id="heading{{ l.id }}">
              <h5 class="mb-0" style="text-align: center;">
                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{ l.id }}"
                  aria-expanded="true" aria-controls="collapse{{ l.id }}">
                  {{ l.name }}
                </button>
              </h5>
            </div>

            <div id="collapse{{ l.id }}" class="collapse show" aria-labelledby="heading{{ l.id }}"
              data-parent="#accordion">
              <div class="card-body">

                <div class="row">
                  <div class="col card" ng-repeat="v in l.videos" style="width: 18rem;">
                    <img class="card-img-top" src="{{ v.imageurl }}" alt="Card image cap">
                    <div class="card-body">
                      <h5 class="card-title">{{ v.title }}</h5>
                      <p class="card-text">{{ v.description }}</p>
                      <a href="{{ v.url }}" class="btn btn-primary">Watch</a>
                    </div>
                  </div>
                </div>


              </div>
            </div>
          </div>


        </div>
      </div>

    </div>
  </article>

  <hr />

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
    integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
    crossorigin="anonymous"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
  <?php
  $playlistApiUrl = getenv('PLAYLIST_API');
  ?>
<?php
// Fetch playlist data from API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $playlistApiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$playlistData = curl_exec($ch);
curl_close($ch);

// Convert the JSON response to a PHP array
$playlistArray = json_decode($playlistData, true);
?>

<script>
var model = {
  playlist: [],
};

var app = angular.module('videos', []);

app.controller('videosController', function ($scope) {
  // Get the PHP array and convert it to a JavaScript array
  model.playlist = <?php echo json_encode($playlistArray); ?>;

  // Assign the playlist to the AngularJS scope
  $scope.playlist = model.playlist;

});

</script>

</body>

</html>
