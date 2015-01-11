<html>
    <head>
    	<meta charset="UTF-8">
    	<title>Games</title>
    	<link href="{{ secure_asset('css/bootstrap.min.css') }}" rel="stylesheet">
    </head>
    <body>
        @if(Session::has('message'))
            <div class="alert-box success">
                <h2>{{ Session::get('message') }}</h2>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped">
              <caption>Overview of all games.</caption>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Word</th>
                  <th>Solution</th>
                  <th>Tries Left</th>
                  <th>Status</th>
                  <th>Created at</th>
                  <th>Updated at</th>
                </tr>
              </thead>
              <tbody>
                @foreach($data as $game)
                    <tr>
                      <th scope="row">{{ $game->id; }}</th>
                      <td>{{ $game->word; }}</td>
                      <td>{{ $game->solution; }}</td>
                      <td>{{ $game->tries_left; }}</td>
                      <td>{{ $game->status; }}</td>
                      <td>{{ $game->created_at; }}</td>
                      <td>{{ $game->updated_at; }}</td>
                    </tr>
                @endforeach

              </tbody>
            </table>
        </div>
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> <!-- use Google CDN for jQuery to hopefully get a cached copy -->
        <script src="{{ secure_asset('js/bootstrap.min.js') }}"></script>
    </body>
</html>