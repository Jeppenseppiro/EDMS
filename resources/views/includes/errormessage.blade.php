@if(count($errors))
  @foreach($errors->all() as $error)
  <a class="btn btn-info errorMessage" data-autohide="false" onclick="toastr.error('{{ $error }}');" hidden></a>
  {{-- <div role="alert" aria-live="assertive" aria-atomic="true" class="toast" data-autohide="false">
    <div class="toast-header danger-color" style="color: white;">
      <strong class="mr-auto">Error</strong>
      <small>just now</small>
      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="toast-body">
      {{ $error }}
    </div>
  </div> --}}
  @endforeach
@endif