<html>
<head></head>
<body>
  <h1>Create Document</h1>
  @if (count($errors) > 0)
    <div>
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="/documents" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}

    <p>
      <label for="file">File</label>
      <input type="file" name="file">
    </p>

    <input type="submit">
  </form>
</body>
</html>
