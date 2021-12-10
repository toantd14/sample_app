<div class="modal fade" id="modalParkingExist" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="exampleModalLabel">{{ session('parkingSpaceExist') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="border m-auto w-50 text-center">
                    <tr>
                        <th class="px-3 border">記号</th>
                        <th class="px-3 border">記号</th>
                    </tr>
                        <td class="px-3 border" id="modal_space_symbol">{{ old('space_symbol') }}</td>
                        <td class="px-3 border" id="modal_space_no">{{ old('space_no_from') }} ~ {{ old('space_no_to') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
