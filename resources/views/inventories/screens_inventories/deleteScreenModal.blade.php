<div class="modal fade" id="deleteScreenModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-deleteScreen" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-deleteScreen">Delete Screen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteScreenForm">
                <div class="modal-body">
                    Are you sure to delete this Screen?
                    <input type="hidden" id="deleteScreenId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="deleteScreenBtn" class="btn btn-primary">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
