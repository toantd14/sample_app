<div class="modal fade" id="modalDelete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body modal-delete">
                <h6>選択したお知らせを削除します。よろしいですか？</h6>
                <form action="" method="POST" id="form-delete">
                    @method("DELETE")
                    @csrf
                    <button type="submit" class="btn btn-success">OK</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                </form>
            </div>
        </div>
    </div>
</div>

