@if(session()->has('success'))
    <div class="alert alert-success alert-dismissible flat shadow-lg z-index-high flash-removable" role="alert"
         style="position:fixed;top: 0;right: 0;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <span class="fa fa-check-circle"></span> {{ session('success') }}
    </div>
@endif
@if(session()->has('info'))
    <div class="alert alert-warning alert-dismissible flat shadow-lg z-index-high flash-removable" role="alert"
         style="position:fixed;top: 0;right: 0;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <span class="fa fa-check-circle"></span> {{ session('info') }}
    </div>
@endif
