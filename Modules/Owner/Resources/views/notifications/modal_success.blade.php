<div class="modal fade in" id="modalSuccess">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body modal-notification">
                {{ session('success') }}
            </div>
            <div class="modal-footer">
                <a href="{{ route('notifications.index') }}" class="btn btn-success">OK</a>
            </div>
        </div>
    </div>
</div>

