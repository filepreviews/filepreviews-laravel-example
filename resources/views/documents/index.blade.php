<html>
<head></head>
<body>
  <h1>Documents</h1>
  <p><a href="{{ route('documents.create') }}">Create Document</a></p>
  @foreach ($documents as $document)
    <ul id="document-{{ $document->id }}">
      <li>ID: {{ $document->id }}</li>
      <li>Name: <a href="{{ $document->url }}">{{ $document->name }}</a></li>
      <li class="preview-url">
        @if ($document->preview_url)
            <a href="{{ $document->preview_url }}">Preview</a>
        @else
          No Preview
        @endif
      </li>
    </ul>
  @endforeach

  <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
  <script src="https://js.pusher.com/3.0/pusher.min.js"></script>
  <script>
    $(function() {
      // Enable pusher logging - don't include this in production
      Pusher.log = function(message) {
        if (window.console && window.console.log) {
          window.console.log(message);
        }
      };

      var pusherKey = '{{ config('broadcasting.connections.pusher.key') }}',
          pusher = new Pusher(pusherKey, { encrypted: true }),
          channel = pusher.subscribe('filepreviews');

      channel.bind('filepreviews.generated', function(data) {
        var $doc = $('#document-' + data.document.id),
            $previewUrl = $doc.find('.preview-url');

        $previewUrl.html('<a href="' + data.document.preview_url + '">Preview</a>');
      });
    });
  </script>
</body>
</html>
