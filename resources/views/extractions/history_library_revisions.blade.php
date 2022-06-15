<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <title>EDMS | @yield('title')</title>
  <style>
    table {
      font-size: 12px;
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    th {
      font-size: 14px;
      text-align: center;
    }

    td {
      text-align: left;
      padding: 4px;
    }

    td,
    th {
      border: 1px solid #000000;
    }

    /* tr:nth-child(even) {
        background-color: #dddddd;
      } */
  </style>
</head>

<body>
  <h2>Document Revision History</h2>
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col" width="20%">Document Title</th>
        <th scope="col" width="10%">Document Type</th>
        <th scope="col" width="10%">Revision No.</th>
        <th scope="col" width="15%">Revision Date</th>
        <th scope="col" width="25%">Revision Purpose</th>
        <th scope="col" width="20%">Attachment</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($document_libraries as $document_library)
        @foreach ($document_library->documentMultipleRevision as $document_revision)
          <tr>
            <td>{{ $document_library->description }}</td>
            <td style="text-align: center;">{{ $document_library->documentCategory->category_description }}</td>
            <td style="text-align: center;">{{ $document_revision->revision }}</td>
            <td style="text-align: center;">{{ date('Y-m-d', strtotime($document_revision->created_at)) }}</td>
            <td>{{ $document_revision->remarks }}</td>
            <td>
              <table class="table table-hover">

                @foreach ($document_revision->documentFileRevision as $document_file_revision)
                  <tr>
                    <td><a href="{{ url('assad.png') }}" target="_blank">{{ $document_file_revision->attachment }}</a></td>
                  </tr>
                @endforeach

              </table>

            </td>
          </tr>
        @endforeach
      @endforeach
    </tbody>
  </table>
</body>

</html>
