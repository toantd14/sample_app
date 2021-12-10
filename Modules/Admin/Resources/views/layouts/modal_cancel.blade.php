<div class="modal fade show" id="modalCancel" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">登録をキャンセルします。よろしいですか？</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <a href="{{ route('owners.index') }}" id="btn-cancel" class="btn btn-primary text-white">OK</a>
                <a class="btn btn-secondary text-white" data-dismiss="modal">キャンセル</a>
            </div>
        </div>
    </div>
</div>
